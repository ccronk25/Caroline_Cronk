using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.ModelBinding;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace CostumeArchive.Pages
{
    public class AccountModel : PageModel
    {
        public PasswordHasher<CostumeArchiveUser> hasher = new PasswordHasher<CostumeArchiveUser>();

		public string passwordChangeMessage = string.Empty;
        public string privacyChangeMessage = string.Empty;
        public string username { get; set; }

        [BindProperty]
		public string? privacy { get; set; }

		[BindProperty]
		public string? password { get; set; }

		[BindProperty]
		public string? newPassword { get; set; }

		[BindProperty]
		public string? confirmPassword { get; set; }

        private readonly UserManager<CostumeArchiveUser> _userManager;
        public AccountModel(UserManager<CostumeArchiveUser> userManager)
        {
            _userManager = userManager;
        }
        private async Task getInfo()
        {
            var user = await _userManager.GetUserAsync(User);
			string userID = user.userID;

			string queryString = "SELECT name, privacy FROM dbo.[USER] WHERE ID = @0;";
			string[] parameters = { userID };
			List<Dictionary<string, string>> result = Database.query(queryString, parameters);

			if (result.Count > 0)
			{
				Dictionary<string, string> currentEntry = result[0];
				privacy = currentEntry["privacy"];
				username = currentEntry["name"];

			}
		}

		public async Task OnGet()
        {
			if (User.Identity.IsAuthenticated)
			{
				await getInfo();
			}
        }

		//https://www.youtube.com/watch?v=-6PE4p4gUYQ
		public async Task<IActionResult> OnPostUpdatePrivacy()
		{

            try
            {
                var user = await _userManager.GetUserAsync(User);
                string userID = user.userID;

                var insertCommand = "UPDATE dbo.[USER] SET privacy = @0 WHERE ID = @1;";
                string[] parameters = { privacy, userID };
                Database.query(insertCommand, parameters);

                privacyChangeMessage = "Privacy updated successfully";
            }
            catch
            {
                privacyChangeMessage = "Error updating privacy";
            }

            await getInfo();
            return Page();
        }

		public async Task<IActionResult> OnPostUpdatePassword()
		{
            await getInfo();

            validatePassForm();
 
            if (!ModelState.IsValid)
			{
                return Page();
			}

            try
            {
                var user = await _userManager.GetUserAsync(User);
                string userID = user.userID;

                string queryString = "SELECT password FROM dbo.[USER] WHERE ID = @0;";
				string[] parameters = { userID };
				List<Dictionary<string, string>> result = Database.query(queryString, parameters);

				string retrievedPass = string.Empty;

				if (result.Count > 0)
				{
					Dictionary<string, string> currentEntry = result[0];
					retrievedPass = currentEntry["password"];
				}

                if (hasher.VerifyHashedPassword(user, retrievedPass, password) == PasswordVerificationResult.Failed)
				{

                    ModelState.AddModelError("password", "Incorrect password");
                    return Page();
                }

                string hashPassword = hasher.HashPassword(user, newPassword);

                var insertCommand = "UPDATE dbo.[USER] SET password = @0 WHERE ID = @1;";
                string[] parameters2 = { hashPassword, userID };
                Database.query(insertCommand, parameters2);

				passwordChangeMessage = "Password updated successfully";
            }
            catch
			{
                passwordChangeMessage = "Error updating password";
            }

            await getInfo();
            return Page();
		}

        //https://stackoverflow.com/questions/48516547/how-to-implement-two-forms-with-separate-bindproperties-in-razor-pages
        public void validatePassForm()
		{
			string[] properties = { password, newPassword, confirmPassword };
			string[] names = { "password", "newPassword", "confirmPassword" };
			
			for(int i = 0; i < properties.Length; i++)
			{
				if (string.IsNullOrEmpty(properties[i]))
				{
					ModelState.AddModelError(names[i], "Required field");
				}
				else if(properties[i].Length > 30 || properties[i].Length < 6)
				{
					ModelState.AddModelError(names[i], "Password must have between 6 and 30 characters");
				}
			}

			if(newPassword != confirmPassword)
			{
				ModelState.AddModelError("confirmPassword", "Passwords must match");

			}
;		}
    }
}
