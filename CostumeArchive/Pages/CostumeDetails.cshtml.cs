using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.Collections.Generic;

namespace CostumeArchive.Pages
{
    public class CostumeDetailsModel : PageModel
    {
		public Costume currentCostume { get; set; }
		public bool canEdit { get; set; } = false;
		public bool canDelete { get; set; } = false;

		[BindProperty]
		public string searchTerm { get; set; }

		[BindProperty]
		public string costumeID { get; set; }

		[BindProperty]
		public string collectionID { get; set; }

		private readonly UserManager<CostumeArchiveUser> _userManager;
		public CostumeDetailsModel(UserManager<CostumeArchiveUser> userManager)
		{
			_userManager = userManager;
		}
		public void getCurrentCostume(string costumeID)
		{
			string querySting = "SELECT * FROM dbo.COSTUME WHERE ID = @0;";
			string[] parameters = { costumeID };

			List<Dictionary<string,string>> result = Database.query(querySting, parameters);
			if(result.Count > 0)
			{
				Dictionary<string, string> currentEntry = result[0];
				string id = currentEntry["ID"];
				string collectionID = currentEntry["collectionID"];
				string title = currentEntry["name"];
				string location = currentEntry["location"];
				string category = currentEntry["category"];
				string notes = "";
				string img = currentEntry["img"];

				if (!String.IsNullOrEmpty(currentEntry["notes"]))
				{
					notes = currentEntry["notes"];
				}

				currentCostume = new Costume(id, title, collectionID, location, category, notes, img);
			}
		}

		public void getPermissions(string userID, string collectionID)
		{
			//Gets non-owner permissions
			string queryString = "SELECT canEdit, canDelete FROM dbo.PERMISSION WHERE userID = @0 and collectionID = @1;";
			string[] parameters = { userID, collectionID };

			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			if (result.Count > 0)
			{
				//https://stackoverflow.com/questions/49590754/convert-a-string-to-a-boolean-in-c-sharp

				string edit = result[0]["canEdit"];
				string delete = result[0]["canDelete"];
				canEdit = bool.Parse(edit);
				canDelete = bool.Parse(delete);
			}

			//Gets owner permissions
			string queryString2 = "SELECT ownerID FROM dbo.COLLECTION WHERE ID = @0;";
			string[] parameters2 = { collectionID };

			List<Dictionary<string, string>> result2 = Database.query(queryString2, parameters2);

			if (result2.Count > 0)
			{
				//https://stackoverflow.com/questions/49590754/convert-a-string-to-a-boolean-in-c-sharp

				if(userID == result2[0]["ownerID"])
				{
					canEdit = true;
					canDelete = true;
				}
			}
		}

		public async Task<IActionResult> OnPostDelete()
		{
			//delete costume
			string queryString = "DELETE FROM COSTUME WHERE ID = @0;";
			string[] parameters = { costumeID };	
			Database.query(queryString, parameters);

			//delete its colors, era, and measurements
			string queryString2 = "DELETE FROM COLOR WHERE costumeID = @0;";
			string[] parameters2 = { costumeID };
			Database.query(queryString2, parameters2);

			queryString2 = "DELETE FROM ERA WHERE costumeID = @0;";
			Database.query(queryString2, parameters2);

			queryString2 = "DELETE FROM MEASUREMENT WHERE costumeID = @0;";
			Database.query(queryString2, parameters2);

			return RedirectToPage("./CostumeSearch");
		}
		public async Task  OnGet()
		{
			if (User.Identity.IsAuthenticated)
			{
				if (!String.IsNullOrEmpty(Request.Query["costume"]))
				{
					getCurrentCostume(Request.Query["costume"]);
				}

				var user = await _userManager.GetUserAsync(User);
				getPermissions(user.userID, currentCostume.collectionID);

				//get the search term for the back button
				if (!string.IsNullOrEmpty(HttpContext.Session.GetString("searchTerm")))
				{
					user.searchTerm = HttpContext.Session.GetString("searchTerm");
					searchTerm = user.searchTerm;
				}
			}
        }
    }
}
