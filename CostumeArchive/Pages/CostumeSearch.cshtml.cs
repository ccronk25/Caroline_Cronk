using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using System.Collections.Generic;
using System.Drawing;
using System.Reflection;

namespace CostumeArchive.Pages
{
    public class CostumeSearchModel : PageModel
    {
		public List<Costume> costumes { get; set; } = new List<Costume>();

        private readonly UserManager<CostumeArchiveUser> _userManager;
        public CostumeSearchModel(UserManager<CostumeArchiveUser> userManager)
        {
            _userManager = userManager;
        }
        public void search(string searchString, string collectionID)
        {
			//allow all results containing search string
			searchString = "%" + searchString + "%";
	
			string selectCommand = "SELECT * FROM dbo.[COSTUME] WHERE name LIKE @0 AND collectionID = @1;";
			string[] parameters = { searchString, collectionID };
			List<Dictionary<string, string>> result = Database.query(selectCommand, parameters);

			//remove old search results 
			costumes.Clear();

			//create costumes and add them to the list to be displayed
			if (result.Count > 0)
			{
				foreach (Dictionary<string, string> currentEntry in result)
				{
					string id = currentEntry["ID"];
					string title = currentEntry["name"];
					string location = currentEntry["location"];
					string category = currentEntry["category"];
					string notes = "";
					string img = currentEntry["img"];

					if (!String.IsNullOrEmpty(currentEntry["notes"])){
						 notes = currentEntry["notes"];
					}

					Costume costume = new Costume(id, title, collectionID, location, category, notes, img);

					costumes.Add(costume);
				}
			}
		}

		private void filter(string colors, string start, string end)
		{
			List<Costume> removeCostumes = new List<Costume>();

			//colors
			if (!string.IsNullOrEmpty(colors))
			{
				//https://learn.microsoft.com/en-us/dotnet/csharp/how-to/parse-strings-using-split
				string[] selectedColors = colors.Split(',');

				if (selectedColors.Length > 0)
				{
					foreach (Costume costume in costumes)
					{
						//costumes marked for removal unless their colors contain 1+ selected colors
						bool remove = true;
						foreach (string color in costume.colors)
						{
							if (selectedColors.Contains(color))
							{
								remove = false;
							}
						}
						if (remove)
						{
							removeCostumes.Add(costume);
						}

					}
				}

			}

			//era
			int intStart;
			int intEnd;

			//if the costume era ends before the start of the filter era, get rid of it

			//https://learn.microsoft.com/en-us/dotnet/csharp/programming-guide/types/how-to-convert-a-string-to-a-number
			if (Int32.TryParse(start, out intStart))
			{
				foreach (Costume costume in costumes)
				{
					if (costume.eraEnd < intStart)
					{
						removeCostumes.Add(costume);
					}
				}
			}

			//if the costume era starts after the end of the filter era, get rid of it
			if (Int32.TryParse(end, out intEnd))
			{
				foreach (Costume costume in costumes)
				{
					if (costume.eraStart > intEnd)
					{
						removeCostumes.Add(costume);
					}
				}
			}

			//remove all marked costumes
			foreach (Costume costume in removeCostumes)
			{
				costumes.Remove(costume);
			}

		}

		//Scan through all the costumes and to find all colors referred to in this collection 
		private List<SelectListItem> getUniqueColors()
		{
			List<string> uniqueColors = new List<string>();

			//get colors without repeats
			foreach (Costume costume in costumes)
			{
				foreach(string color in costume.colors)
				{
					if (!uniqueColors.Contains(color) && !string.IsNullOrEmpty(color))
					{
						uniqueColors.Add(color);
					}
				}
			}
			//Sort them alphabetically
			//https://learn.microsoft.com/en-us/dotnet/api/system.collections.generic.list-1.sort?view=net-8.0
			uniqueColors.Sort();

			//https://learn.microsoft.com/en-us/answers/questions/1161372/binding-a-checkbox-list-on-razor-page-net-core-6-0
			List<SelectListItem> colors = new List<SelectListItem>();

			foreach (string color in uniqueColors)
			{
				SelectListItem item = new SelectListItem() { Text = color, Value = color };
				colors.Add(item);
			}

			return colors;
			
		}
		public async Task OnGet()
		{
			if (User.Identity.IsAuthenticated)
            {
                var user = await _userManager.GetUserAsync(User);

                //set the search term to the new query from the url
                if (!string.IsNullOrEmpty(Request.Query["search"]))
                {
                    user.searchTerm = Request.Query["search"];
                }

				if (!string.IsNullOrEmpty(HttpContext.Session.GetString("collectionID")))
				{
					user.collectionID = HttpContext.Session.GetString("collectionID");
				}


				//search
				if (!string.IsNullOrEmpty(user.searchTerm) && !string.IsNullOrEmpty(user.collectionID))
                {
                    HttpContext.Session.SetString("searchTerm", user.searchTerm);
                    search(user.searchTerm, user.collectionID);
                    ViewData["colors"] = new SelectList(getUniqueColors(), "Value", "Text");
                }

                filter(Request.Query["color"], Request.Query["start"], Request.Query["end"]);
            }
		}

	}
}
