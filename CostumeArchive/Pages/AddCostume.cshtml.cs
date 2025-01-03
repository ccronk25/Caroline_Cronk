using CostumeArchive.Data;
using CostumeArchive.Classes;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.ComponentModel.DataAnnotations;

namespace CostumeArchive.Pages
{
    public class AddCostumeModel : PageModel
    {
        public static string[] categories = { "Dress", "Suit", "Jumpsuit", 
                                            "Shirt", "Jacket", "Sweater", "Vest", "Sweatshirt", 
                                            "Skirt", "Pants", "Shorts", "Leggings", 
                                            "Hat", "Tie", "Belt", "Gloves", "Socks" };
        //required
        [Required(ErrorMessage = "Costume must have a title")]
        [BindProperty] public string title { get; set; }
        [BindProperty] public string collectionID { get; set; }

        //core functionality
        [BindProperty] public string? sLocation { get; set; } = string.Empty;
		[BindProperty] public string category { get; set; } = string.Empty;
        [BindProperty] public string? notes { get; set; } = string.Empty;
        [BindProperty] public string? image { get; set; } = string.Empty;

        //tags
        //enforce that era is numbers to make filtering possible
        [BindProperty] public int? eraStart { get; set; }
        [BindProperty] public int? eraEnd { get; set; }
        [BindProperty] public string? color1 { get; set; } = string.Empty;
        [BindProperty] public string? color2 { get; set; } = string.Empty;

        //measurements
        //(there was definitely a better way to do this)
        [BindProperty] public string? chest { get; set; } = string.Empty;
        [BindProperty] public string? waist { get; set; } = string.Empty;
        [BindProperty] public string? hip { get; set; } = string.Empty;
        [BindProperty] public string? acrossBack { get; set; } = string.Empty;
        [BindProperty] public string? neckToWaist { get; set; } = string.Empty;
        [BindProperty] public string? waistToHem { get; set; } = string.Empty;
        [BindProperty] public string? shoulderToWrist { get; set; } = string.Empty;
        [BindProperty] public string? head { get; set; } = string.Empty;
        [BindProperty] public string? neck { get; set; } = string.Empty;
        [BindProperty] public string? armscye { get; set; } = string.Empty;
        [BindProperty] public string? elbow { get; set; } = string.Empty;
        [BindProperty] public string? wrist { get; set; } = string.Empty;
        [BindProperty] public string? inseam { get; set; } = string.Empty;

        private readonly UserManager<CostumeArchiveUser> _userManager;
        public AddCostumeModel(UserManager<CostumeArchiveUser> userManager)
        {
            _userManager = userManager;
        }

        public IActionResult OnPost()
        {
            if (!ModelState.IsValid)
            {
                return Page();
            }

            try
            {
                //base costume table
                string queryString1 = "INSERT INTO dbo.[COSTUME] (name, collectionID, location, category, img, notes) VALUES(@0, @1, @2, @3, @4, @5);";
                string[] parameters1 = { title, collectionID, sLocation, category, image, notes };

                Database.query(queryString1, parameters1);

                //get id from costume table, trying to string together a key
                string queryString2 = "SELECT ID from dbo.[COSTUME] WHERE name = @0 AND collectionID = @1;";
                string[] parameters2 = { title, collectionID};

                string costumeID = string.Empty;
                List<Dictionary<string,string>> result = Database.query(queryString2, parameters2);
                if (result.Count > 0)
                {
                    costumeID = result[0]["ID"];
                }
                else //if it didn't find anything, something went wrong
                {
                    ModelState.AddModelError("title", "Error connecting to server");
                    return Page();
                }

                string end = string.Empty;
                string start = string.Empty;
                //era table
                if (eraEnd != null)
                {
                    end = eraEnd.ToString();
                }
                if (eraStart != null)
                {
                    start = eraStart.ToString();
                }

                string queryString3 = "INSERT INTO dbo.[ERA] (costumeID, start, [end]) VALUES(@0, @1, @2);";
                string[] parameters3 = { costumeID, start, end };

                Database.query(queryString3, parameters3);

                //color table
                string queryString4 = "INSERT INTO dbo.[COLOR] (costumeID, color1, color2) VALUES(@0, @1, @2);";
                string[] parameters4 = { costumeID, color1, color2 };

                Database.query(queryString4, parameters4);

                //measurment table
                string queryString5 = "INSERT INTO dbo.[MEASUREMENT] (costumeID, chest, waist, hip, acrossBack, neckToWaist, waistToHem, head, neck, armscye, elbow, wrist, inseam) VALUES(@0, @1, @2, @3, @4, @5, @6, @7, @8, @9, @10, @11, @12);";
                string[] parameters5 = { costumeID, chest, waist, hip, acrossBack, neckToWaist, waistToHem, head, neck, armscye, elbow, wrist, inseam };

                Database.query(queryString5, parameters5);
            }
            catch
            {
                ModelState.AddModelError("title", "Could not create costume");
                return Page();
            }

            //if they made it this far, the form's info is complete and in the database.
            return RedirectToPage("./MyCollections");
        }
        public async Task OnGet()
        {
            if (!String.IsNullOrEmpty(Request.Query["collection"]))
            {
                collectionID = Request.Query["collection"];
            }
        }
    }
}
