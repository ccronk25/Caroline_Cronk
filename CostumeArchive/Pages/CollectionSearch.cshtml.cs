using CostumeArchive.Classes;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.Globalization;
using System.Reflection;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Identity;


namespace CostumeArchive.Pages
{
    public class CollectionSearchModel : PageModel
	{
		[BindProperty]
		public string collectionID { get; set; }
		public List<Collection> collections { get; set; } = new List<Collection>();
		public List<Collection> userCollections { get; set; } = new List<Collection>();
		public List<string> pendingCollections { get; set; } = new List<string>();

		private readonly UserManager<CostumeArchiveUser> _userManager;
		public CollectionSearchModel(UserManager<CostumeArchiveUser> userManager)
		{
			_userManager = userManager;
		}

		public void search(string searchString)
        {
			//allow all results containing search string
			searchString = "%" + searchString + "%";

			//search for all collections with privacy set to show up in collection searches (all but invite only, which are unlisted)
			string selectCommand = "SELECT * FROM dbo.[COLLECTION] WHERE name LIKE @0 AND privacy != @1 AND privacy != @2;";
			string[] parameters = { searchString, "inviteOnly", "locked" };
			List<Dictionary<string, string>> result = Database.query(selectCommand, parameters);

			//remove old search results
			collections.Clear();

			//create collections and add them to the list to be displayed
			if (result.Count > 0)
			{
				foreach (Dictionary<string, string> currentEntry in result)
				{
					string ID = currentEntry["ID"];
					string ownerID = currentEntry["ownerID"];
					string name = currentEntry["name"];
					string location = currentEntry["location"];
					string privacy = currentEntry["privacy"];

					Collection collection = new Collection(ID, ownerID, name, location, privacy);

					collections.Add(collection);
				}
			}
		}

		public async Task getCollections()
		{
			//get collections that the user has access to
			var user = await _userManager.GetUserAsync(User);
            string userID = user.userID;

			//grab from both owned and shared
			string queryString =
				"SELECT DISTINCT ID, ownerID, name, location, privacy FROM dbo.[COLLECTION], dbo.[PERMISSION] WHERE COLLECTION.ownerID = @0 OR COLLECTION.ID = PERMISSION.collectionID AND PERMISSION.userID = @0;";

			string[] parameters = { userID };

			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			//if the result isn't empty, unpack it
			if (result.Count > 0)
			{
				foreach (Dictionary<string, string> currentEntry in result)
				{
					string ID = currentEntry["ID"];
					string ownerID = currentEntry["ownerID"];
					string name = currentEntry["name"];
					string location = currentEntry["location"];
					string privacy = currentEntry["privacy"];

					Collection collection = new Collection(ID, ownerID, name, location, privacy);

					userCollections.Add(collection);
				}
			}

			//get IDs for collections that user is currently requesting to join
			string queryString2 = "SELECT collectionID FROM dbo.[NOTIFICATION] WHERE senderID = @0 AND response = @1;";
			string[] parameters2 = { userID, "pending" };

			List<Dictionary<string, string>> result2 = Database.query(queryString2, parameters2);

			//if the result isn't empty, unpack it
			if (result2.Count > 0)
			{
				foreach (Dictionary<string, string> currentEntry in result2)
				{
					string ID = currentEntry["collectionID"];
					pendingCollections.Add(ID);
				}
			}
		}

		public async Task OnPostAddCollection()
		{
			var user = await _userManager.GetUserAsync(User);
			string userID = user.userID;

			//the collections disappear on post
			search(user.searchTerm);

			//add the user to the permissions
			string queryString = "INSERT INTO dbo.PERMISSION (userID, collectionID) VALUES (@0, @1);";
			string[] parameters = { userID, collectionID };
			Database.query(queryString, parameters);

			//notify the owner
			//get collection info 
			Collection collection = collections.First(n => n.ID == collectionID);
			string collectionName = collection.name;
			string owner = collection.ownerID;

			//create content
			string title = "User Joined Collection";
			string messsage = "User " + user.UserName + " has joined your collection " + collectionName + ".";

			Notification.sendNotification(owner, userID, title, messsage, collectionID, false);

			//show updated collection options (so they can't click "add" again)
			await getCollections();
		}

		public async Task OnPostRequestAccess()
		{
			var user = await _userManager.GetUserAsync(User);
			string userID = user.userID;

			//the collections disappear on post
			search(user.searchTerm);

			//notify owner
			//get collection info 
			Collection collection = collections.First(n => n.ID == collectionID);
			string collectionName = collection.name;
			string owner = collection.ownerID;

			//create content
			string title = "Request to Join Collection";
			string messsage = "User " + user.UserName + " has requested to join your collection, " + collectionName;

			//requires a response from the owner
			Notification.sendNotification(owner, userID, title, messsage, collectionID, true);

			//Notification already marks access as pending, which will disable/remove request access button

			//show updated collection options (so they can't click "request" again)
			await getCollections();
		}

		public async Task OnGet()
        {
			if (User.Identity.IsAuthenticated)
			{
				var user = await _userManager.GetUserAsync(User);

				//get list of collections the user has access to for checking what buttons should be available to them 
				await getCollections();

				//set the search term to the new query from the url
				if (!String.IsNullOrEmpty(Request.Query["search"]))
				{
					user.searchTerm = Request.Query["search"];
				}

				if (!string.IsNullOrEmpty(user.searchTerm))
				{
					HttpContext.Session.SetString("searchTerm", user.searchTerm);
					search(user.searchTerm);
				}
			}
		}
    }
}
