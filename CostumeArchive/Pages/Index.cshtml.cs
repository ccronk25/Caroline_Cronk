using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Identity.EntityFrameworkCore;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.ComponentModel.DataAnnotations;
using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Identity.UI.Services;
using Microsoft.AspNetCore.WebUtilities;

//https://learn.microsoft.com/en-us/aspnet/core/security/authentication/identity?view=aspnetcore-8.0&tabs=visual-studio
//https://learn.microsoft.com/en-us/aspnet/identity/overview/getting-started/adding-aspnet-identity-to-an-empty-or-existing-web-forms-project

namespace CostumeArchive.Pages
{
    public class IndexModel : PageModel
    {
        private PasswordHasher<CostumeArchiveUser> hasher = new PasswordHasher<CostumeArchiveUser>();
        private readonly SignInManager<CostumeArchiveUser> _signInManager;
        private readonly UserManager<CostumeArchiveUser> _userManager;
        private readonly IUserStore<CostumeArchiveUser> _userStore;
        private readonly ILogger<IndexModel> _logger;

        [BindProperty]
        [StringLength(60)]
        [MinLength(3)]
        [Required(ErrorMessage = "Username is required")]
        public string username { get; set; } = string.Empty;

        [BindProperty]
        [StringLength(30)]
        [MinLength(6)]
        [Required(ErrorMessage = "Password is required")]
        public string password { get; set; } = string.Empty;

        public IndexModel(SignInManager<CostumeArchiveUser> signInManager, UserManager<CostumeArchiveUser> userManager, IUserStore<CostumeArchiveUser> userStore, ILogger<IndexModel> logger)
        {
            _signInManager = signInManager;
            _userManager = userManager;
            _userStore = userStore;
            _logger = logger;
        }

        private string getPassword()
        {
            string retrievedPass = string.Empty;

            string queryString = "SELECT password FROM dbo.[USER] WHERE name = @0;";
            string[] parameters = { username };
            List<Dictionary<string, string>> result = Database.query(queryString, parameters);

            if (result.Count > 0)
            {
                Dictionary<string, string> currentEntry = result[0];
                retrievedPass = currentEntry["password"];
            }
            return retrievedPass;
        }

        //pulls ID from user to check that there is a user with that name in the database
        private bool usernameExists(string username)
        {
            bool nameExists = false;

            string queryString = "SELECT ID FROM dbo.[USER] WHERE name = @0;";
            string[] parameters = { username };
            List<Dictionary<string, string>> result = Database.query(queryString, parameters);

            if (result.Count > 0)
            {
               nameExists = true;
            }

            return nameExists;
        }



        public async Task<IActionResult> OnPostAsync()
        {
            if (ModelState.IsValid)
            {

                if (usernameExists(username))
                {
                    var user = CreateUser();
                    await _userManager.SetUserNameAsync(user, username);
                    //  await _userStore.SetUserNameAsync(user, username, CancellationToken.None);

                    string retrievedPass = getPassword();
                    //https://learn.microsoft.com/en-us/dotnet/api/microsoft.aspnetcore.identity.passwordhasher-1.verifyhashedpassword?view=aspnetcore-8.0#microsoft-aspnetcore-identity-passwordhasher-1-verifyhashedpassword(-0-system-string-system-string)
                    if (hasher.VerifyHashedPassword(user, retrievedPass, password) == PasswordVerificationResult.Success)
                    {
                        user.findID();
                        await _userManager.CreateAsync(user);
                        await _signInManager.SignInAsync(user, isPersistent: false);
                       
                        if(await _userManager.GetUserAsync(User) != null)
                        {
							return RedirectToPage("./MyCollections");
						}
                        else
                        {
                            await _signInManager.SignOutAsync();
                            ModelState.AddModelError("username", "Error logging in");
						}
                    }
                    else
                    {
                        ModelState.AddModelError("password", "Incorrect password");
                    }
                }
                else
                {
                    ModelState.AddModelError("username", "No matching username exists");
                }
            }

            //if it hasn't been redirected yet, something went wrong
            return Page();
           
        }

        public void OnGet()
        {
        }

        //Source: Microsoft Identity scaffolding
        private CostumeArchiveUser CreateUser()
        {
            try
            {
                return Activator.CreateInstance<CostumeArchiveUser>();
            }
            catch
            {
                throw new InvalidOperationException($"Can't create an instance of '{nameof(CostumeArchiveUser)}'. " +
                    $"Ensure that '{nameof(CostumeArchiveUser)}' is not an abstract class and has a parameterless constructor, or alternatively " +
                    $"override the register page in /Areas/Identity/Pages/Account/Register.cshtml");
            }
        }
    }
}



