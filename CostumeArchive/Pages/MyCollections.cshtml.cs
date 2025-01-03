using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Html;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using System.Xml.Linq;


namespace CostumeArchive.Pages
{
    public class MyCollectionsModel : PageModel
    {
        const bool OWNER = true;
		const bool SHARED = false;
		public List<Collection> userCollections { get; set; } = new List<Collection>();
		public List<Collection> sharedCollections { get; set; } = new List<Collection>();

		private readonly UserManager<CostumeArchiveUser> _userManager;
		public MyCollectionsModel(UserManager<CostumeArchiveUser> userManager)
        {
            _userManager = userManager;
        }

        public void getCollections(bool isOwner, string userID)
		{

			//adjust query string if the collections are owned by the user or shared
			string queryString = "SELECT ID, ownerID, name, location, privacy FROM dbo.[COLLECTION]";
			if (isOwner) {
				queryString = queryString + "WHERE ownerID = @0;";
			}
			else
			{
				queryString = queryString + ", dbo.PERMISSION WHERE COLLECTION.ID = collectionID AND PERMISSION.userID = @0;";
			}
			string[] parameters = { userID };

			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			//if the result isn't empty, unpack it
			if (result.Count > 0) { 
				foreach (Dictionary<string, string> currentEntry in result)
				{
					string ID = currentEntry["ID"];
					string ownerID = currentEntry["ownerID"];
					string name = currentEntry["name"];
					string location = currentEntry["location"];
					string privacy = currentEntry["privacy"];

					Collection collection = new Collection(ID, ownerID, name, location, privacy);

					if (isOwner)
					{
						userCollections.Add(collection);
					}
					else
					{
						sharedCollections.Add(collection);
					}
				}
			}
		}

		public async Task loadCollections()
		{
            var user = await _userManager.GetUserAsync(User);
            string userID = user.userID;

            //reset the collection, as we're no longer inside a collection
            user.collectionID = null;

            //reset previous search results
            HttpContext.Session.Remove("searchTerm");

            //remove old results
            userCollections.Clear();
            sharedCollections.Clear();

            if (!string.IsNullOrEmpty(userID))
            {
                getCollections(OWNER, userID);
                getCollections(SHARED, userID);

                string queryString = "SELECT TOP 3 * FROM dbo.[NOTIFICATION] WHERE userID = @0 AND unread = @1 ORDER BY ID DESC; ";
                string[] parameters = { userID, "1" };
                NotificationModel.getNotifications(queryString, parameters);

                //communicate to collection partial what the user's id is without needing to set up a whole async user access
                HttpContext.Session.SetString("userID", userID);
            }
        }

		public async Task OnPost()
		{
            await loadCollections();
			//Collection changedCollection = userCollections.FirstOrDefault(o => o.canAdd != null);
			//Console.WriteLine(changedCollection.ID);
        }

        public async Task OnGet()
        {
			if (User.Identity.IsAuthenticated)
			{
				await loadCollections();
			}
		}
    }
}
