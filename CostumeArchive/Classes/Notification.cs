using CostumeArchive.Pages;

namespace CostumeArchive.Classes
{
	public class Notification
	{
		public string id { get; set; }
		public string title { get; set; }
		public string message { get; set; }
		public string userID { get; set; }
		public string senderID { get; set; }
		public string collectionID { get; set; }
		public string answer { get; set; }
		public bool isRead {  get; set; }

		public static void sendNotification(string targetUser, string sender, string title, string message, string collectionID, bool requiresAnswer)
		{
			string queryString = "INSERT INTO dbo.NOTIFICATION (userID, title, message, response, senderID, collectionID) VALUES (@0, @1, @2, @3, @4, @5);";
			string[] parameters = {targetUser, title, message, "","", ""};

			//if it requires an answer, mark it as pending
			if (requiresAnswer)
			{
				parameters[3] = "pending";
				parameters[4] = sender;
				parameters[5] = collectionID;
			}
			
			//query database to put it in

			Database.query(queryString, parameters);
		}

		public static string respond(string ID, string response)
		{
			//https://stackoverflow.com/questions/3154310/search-list-of-objects-based-on-object-variable
			Notification notif = NotificationModel.notifications.FirstOrDefault(o => o.id == ID);

			string errorMessage = string.Empty;

			if (notif != null) 
			{
				// if no, update it right away
				if(response == "no")
				{
					//update this notification to not be pending
					string queryString = "UPDATE dbo.NOTIFICATION SET response = @0 WHERE ID = @1 ;";
					string[] parameters = { response, ID };
					Database.query(queryString, parameters);
				}
				//if yes, make sure the permission change goes through before updating permissions
				else if (response == "yes")
				{
					//get what user new notification should be sent to (based on what user was from)
					string sender = notif.senderID;					

					//parse message for what should be done based on canned titles text
					//Make new message off of that
					string newTitle = string.Empty;
					string newMessage = string.Empty;

					//both messages require a collection name
					string collectionName = notif.getName("COLLECTION", notif.collectionID);

					string[] parameters1 = new string[2];

					//if they're being invited to a collection
					if (notif.title.Contains("Invite"))
					{
						//this messages requires the user's name
						string userName = notif.getName("USER", notif.userID);

						parameters1[0] = notif.userID; 
						newTitle = "Invite Accepted";
						newMessage = userName + " has accepted your invitation to " + collectionName;
					}
					//if someone else is requesting access to their collection
					else if (notif.title.Contains("Request"))
					{
						parameters1[0] = sender;
						newTitle = "New Shared Collection";
						newMessage = "You have been added to " + collectionName;
					}

					//update permissions
					try 
					{
						string queryString1 = "INSERT INTO dbo.PERMISSION (userID, collectionID) VALUES (@0, @1);";
						parameters1[1] = notif.collectionID;
						Database.query(queryString1, parameters1);

						//send notification to other user
						sendNotification(sender, notif.userID, newTitle, newMessage, notif.collectionID, false);

						//update this notification to not be pending
						string queryString = "UPDATE dbo.NOTIFICATION SET response = @0 WHERE ID = @1 ;";
						string[] parameters = { response, ID };
						Database.query(queryString, parameters);
					}
					catch
					{
						errorMessage = "Unable to send response";
					}
				}
			}
			else
			{
				errorMessage = "Unable to send response";
			}
			return errorMessage;

		}

		//both collection and user have a field "name" which holds the name.
		//This method allows the notifications to access and ID's name by supplying which of the two tables it wants
		private string getName(string tableName, string ID)
		{
			string name = string.Empty;

			//bring tableName to uppercase in case I enter it with the wrong case
			//I was unable to bind a table name as a parameter, so since these are canned queries that only I mess with,
			//I decided to do the slightly less safe concatenation
			string queryString = "SELECT name FROM dbo.[" + tableName.ToUpper() + "] WHERE ID = @0;";
			string[] parameters = { ID };

			List<Dictionary<string, string>> result = Database.query(queryString, parameters);
			if (result.Count > 0)
			{
				name = result[0]["name"];
			}

			return name;
		}

	}
}
