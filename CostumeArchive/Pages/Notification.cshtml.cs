using CostumeArchive.Classes;
using CostumeArchive.Data;
using CostumeArchive.Pages.Partials;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace CostumeArchive.Pages
{
    public class NotificationModel : PageModel
    {
        public static List<Notification> notifications { get; set; } = new List<Notification>();

		[BindProperty]
		public string? id { get; set; }

		public string errorMessage { get; set; } = string.Empty;

        private readonly UserManager<CostumeArchiveUser> _userManager;
        public NotificationModel(UserManager<CostumeArchiveUser> userManager)
		{
			_userManager = userManager;
		}

		public static void getNotifications(string queryString, string[] parameters)
		{
			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			notifications.Clear();

			if (result.Count > 0)
			{
				//Reset notifications so we don't get duplicates

				for (int i = 0; i < result.Count; i++)
				{
					Dictionary<string, string> currentEntry = result[i];
					Notification currentNotif = new Notification();
					currentNotif.id = currentEntry["ID"];
					currentNotif.userID = currentEntry["userID"];
					currentNotif.title = currentEntry["title"];
					currentNotif.message = currentEntry["message"];
					if(!string.IsNullOrEmpty(currentEntry["response"]))
					{
						currentNotif.answer = currentEntry["response"];
						if (currentEntry["response"] == "pending")
						{	
							currentNotif.senderID = currentEntry["senderID"];
							currentNotif.collectionID = currentEntry["collectionID"];
						}	
					}
					else
					{
						currentNotif.answer = string.Empty;
					}

					notifications.Add(currentNotif);
				}
			}
		}

		private void setAsRead(string userID)
		{
			string queryString = "UPDATE dbo.Notification SET unread = @0 WHERE userID = @1;";
			string[] parameters = { "0", userID};

			Database.query(queryString, parameters);
		}

		private async Task loadNotifications()
		{

            var user = await _userManager.GetUserAsync(User);
            string userID = user.userID;
			string queryString = "SELECT * FROM dbo.[NOTIFICATION] WHERE userID = @0 ORDER BY ID DESC;";
			string[] parameters = { userID };

			getNotifications(queryString, parameters);
		}

		//https://stackoverflow.com/questions/20766306/calling-a-c-sharp-function-by-a-html-button
		public async Task OnPostButtonAccept()
		{
			errorMessage = Notification.respond(id, "yes");
			await loadNotifications();
		}

		public async Task OnPostButtonReject()
		{
			errorMessage = Notification.respond(id, "no");
            await loadNotifications();
		}

		public async Task OnGetAsync()
        {
			if (User.Identity.IsAuthenticated)
			{
				await loadNotifications();

				var user = await _userManager.GetUserAsync(User);
				string userID = user.userID;
				setAsRead(userID);
			}
		}
    }
}
