using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Identity;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Reflection;
using Microsoft.AspNetCore.Mvc.ModelBinding;
using CostumeArchive.Classes;
using CostumeArchive.Data;
using Microsoft.AspNetCore.Identity.EntityFrameworkCore;

namespace CostumeArchive.Pages
{
    public class CreateAccountModel : PageModel
    {
        public PasswordHasher<CostumeArchiveUser> hasher = new PasswordHasher<CostumeArchiveUser>();
		private readonly SignInManager<CostumeArchiveUser> _signInManager;
		private readonly UserManager<CostumeArchiveUser> _userManager;

		//https://learn.microsoft.com/en-us/aspnet/core/security/authentication/identity?view=aspnetcore-8.0&tabs=visual-studio
		//https://learn.microsoft.com/en-us/aspnet/core/tutorials/razor-pages/validation?view=aspnetcore-8.0&tabs=visual-studio
		//https://learn.microsoft.com/en-us/aspnet/mvc/overview/older-versions/getting-started-with-aspnet-mvc3/cs/adding-validation-to-the-model

		[BindProperty]
        [MaxLength(40, ErrorMessage = "Username must be less than 40 characters")]
		[MinLength(3, ErrorMessage = "Username must have 3 or more characters")]
		[Required(ErrorMessage = "Username is required")]
        public string username { get; set; } = string.Empty;

        [BindProperty]
        [StringLength(30, MinimumLength = 6, ErrorMessage = "Password must have between 6 and 30 characters")]
        [Required(ErrorMessage = "Password is required")]
        public string password { get; set; } = string.Empty;

        [BindProperty]
        [StringLength(30, MinimumLength = 6, ErrorMessage = "Password must have between 6 and 30 characters")]
        [Required(ErrorMessage = "Password confirmation is required")]
        [Compare(nameof(password), ErrorMessage = "Passwords must match")]
		public string confirmPassword { get; set; } = string.Empty;

        [BindProperty]
        [Required]
        public string privacy { get; set; } = string.Empty;

		public CreateAccountModel(SignInManager<CostumeArchiveUser> signInManager, UserManager<CostumeArchiveUser> userManager)
		{
			_signInManager = signInManager;
			_userManager = userManager;
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

		public void OnGet()
        {
        }

        public async Task<IActionResult> OnPostAsync()
        {
			if (ModelState.IsValid)
			{
				var user = CreateUser();
				await _userManager.SetUserNameAsync(user, username);
				//https://learn.microsoft.com/en-us/dotnet/api/microsoft.aspnetcore.identity.passwordhasher-1?view=aspnetcore-8.0
				string hashPassword = hasher.HashPassword(user, password);

				//attempt to enter new user
				try
				{
					var insertCommand = "INSERT INTO dbo.[USER] (name, password, privacy) VALUES(@0, @1, @2);";
					string[] parameters = { username, hashPassword, privacy };
					Database.query(insertCommand, parameters);

					var queryString = "SELECT ID FROM dbo.[USER] WHERE name = @0;";
					string[] name = { username };
					List<Dictionary<string, string>> result = Database.query(queryString, name);
					string id = result[0]["ID"];
				}
				//usernames must be unique, entering one that's taken will fail
				catch
				{
					ModelState.AddModelError("username", "Username is already taken");
					return Page();
				}

				//if it got past, log in
				user.findID();
				await _userManager.CreateAsync(user);
				await _signInManager.SignInAsync(user, isPersistent: false);

				if (await _userManager.GetUserAsync(User) != null)
				{
					return RedirectToPage("./MyCollections");
				}
				else
				{
					await _signInManager.SignOutAsync();
					ModelState.AddModelError("username", "Error logging in");
				}
			}

			//if it didn't get redirected, something went wrong
			return Page();
		}
    }
}
