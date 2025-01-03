using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.ComponentModel.DataAnnotations;

namespace CostumeArchive.Pages
{
    public class CreateCollectionModel : PageModel
    {
        [BindProperty]
		[Required]
        public string name { get; set; }

		[BindProperty]
		[Required]
		public string location { get; set; }

		[BindProperty]
		[Required]
		public string privacy { get; set; }

		private readonly UserManager<CostumeArchiveUser> _userManager;
		public CreateCollectionModel(UserManager<CostumeArchiveUser> userManager)
		{
			_userManager = userManager;
		}

		public async Task<IActionResult> OnPost()
        {
			if (!ModelState.IsValid)
			{
				return Page();
			}

			var user = await _userManager.GetUserAsync(User);
			string userID = user.userID;

			try {
                string queryString = "INSERT INTO dbo.[COLLECTION] (name, location, privacy, ownerID) VALUES(@0, @1, @2, @3);";
                string[] parameters = { name, location, privacy, userID };

                Database.query(queryString, parameters);

                return RedirectToPage("./MyCollections");
            }
            catch
			{
                ModelState.AddModelError("name", "Error connecting to server");
                return Page();
            }
			
		}
		public void OnGet()
        {
        }
    }
}
