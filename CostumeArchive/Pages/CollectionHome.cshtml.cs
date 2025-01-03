using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace CostumeArchive.Pages
{
    public class CollectionHomeModel : PageModel
    {
		public string collectionName {  get; set; }
		public string collectionID { get; set; }
		public bool canAdd { get; set; }

		private readonly UserManager<CostumeArchiveUser> _userManager;
		public CollectionHomeModel(UserManager<CostumeArchiveUser> userManager)
		{
			_userManager = userManager;
		}
		public void setCollectionInfo(string userID, string collectionID)
		{
			this.collectionID = collectionID;
			string queryString = "SELECT name, ownerID FROM dbo.[COLLECTION] WHERE ID = @0;";
			string[] parameters = { collectionID };

			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			if (result.Count > 0)
			{
				Dictionary<string, string> collection = result[0];
				collectionName = collection["name"];

				string collectionOwner = collection["ownerID"];
				if(collectionOwner == userID)
				{
					canAdd = true;
				}
			}
		}

		public void getPermissions(string userID, string collectionID)
		{
			////this query will not catch the owner, as they don't show up in the permissions table. The getCollectionInfo method sets the owner's permissions
			string queryString = "SELECT canAdd FROM dbo.PERMISSION WHERE userID = @0 and collectionID = @1;";
			string[] parameters = { userID, collectionID };

			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			if (result.Count > 0)
			{
				//https://stackoverflow.com/questions/49590754/convert-a-string-to-a-boolean-in-c-sharp

				string add = result[0]["canAdd"];
				canAdd = bool.Parse(add);
			}
		}

		public async Task OnGet()
        {
			if (User.Identity.IsAuthenticated)
			{
				var user = await _userManager.GetUserAsync(User);

				//reset the search term so it's a fresh search bar
				user.searchTerm = null;

				//set the collection ID from the url search string
				if (!String.IsNullOrEmpty(Request.Query["collection"]))
				{
					user.collectionID = Request.Query["collection"];
					HttpContext.Session.SetString("collectionID", user.collectionID);

					//use collection ID and ownerID to put the collection name in a variable
					setCollectionInfo(user.userID, user.collectionID);

					//check if the user can add to this collection
					getPermissions(user.userID, user.collectionID);
				}
			}
			
		}
    }
}
