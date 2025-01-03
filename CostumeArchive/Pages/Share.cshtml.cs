using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.ComponentModel.DataAnnotations;

namespace CostumeArchive.Pages
{
    public class ShareModel : PageModel
    {
        public List<string> searchableUsers { get; set; } = new List<string>();

		[Required(ErrorMessage = "Provide a username")]
		[BindProperty]
		public string shareUsername { get; set; }
		[Required]
		[BindProperty]
		public string collectionID { get; set; }

        private readonly UserManager<CostumeArchiveUser> _userManager;
        public ShareModel(UserManager<CostumeArchiveUser> userManager)
        {
            _userManager = userManager;
        }
        public void getUsers()
		{
			string queryString = "SELECT name FROM dbo.[USER] WHERE privacy = @0;";
			string[] parameters = { "searchable" };
			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			if (result.Count > 0)
			{
				for (int i = 0; i < result.Count; i++)
				{
					Dictionary<string, string> currentEntry = result[i];
					searchableUsers.Add(currentEntry["name"]);
				}
			}
		}

		public async Task<IActionResult> OnPost()
		{
			if (!ModelState.IsValid)
            {
                return Page();
            }

            //send request via notifiation
			//get the sender
            var user = await _userManager.GetUserAsync(User);
            string senderID = user.userID;

            //get the recipient's ID
            string recieverID = string.Empty;
            string querysting = "SELECT ID FROM dbo.[USER] WHERE name = @0;";
            string[] parameters = { shareUsername };

            List<Dictionary<string, string>> result = Database.query(querysting, parameters);

            if (result.Count > 0)
            {
                recieverID = result[0]["ID"];
            }

            //get the collection's name
            string collectionName = string.Empty;
			string querysting2 = "SELECT name FROM dbo.COLLECTION WHERE ID = @0;";
			string[] parameters2 = { collectionID };

			List<Dictionary<string,string>> result2 = Database.query(querysting2, parameters2);

			if (result.Count > 0)
			{
				collectionName = result2[0]["name"];
			}

			//make the content
            string notifTitle = "New Collection Invite";
			string notifMessage = "User " + user.UserName + " has invited you to their collection " + collectionName + ".";

			try
			{
                Notification.sendNotification(recieverID, senderID, notifTitle, notifMessage, collectionID, true);
            }
			catch
			{
				ModelState.AddModelError("shareUsername", "Unable to send request");
				return Page();
			}
			
            return RedirectToPage("./MyCollections");
        }
		public void OnGet()
        {
			if (User.Identity.IsAuthenticated)
			{
				getUsers();
				if (!String.IsNullOrEmpty(Request.Query["collection"]))
				{
					collectionID = Request.Query["collection"];
				}
			}
        }
    }
}
