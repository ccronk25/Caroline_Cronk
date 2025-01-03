using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Identity;
using CostumeArchive.Data;


namespace CostumeArchive.Pages
{
    public class LogoutModel : PageModel
    {
		private readonly SignInManager<CostumeArchiveUser> _signInManager;
		private readonly UserManager<CostumeArchiveUser> _userManager;

		public LogoutModel(SignInManager<CostumeArchiveUser> signInManager, UserManager<CostumeArchiveUser> userManager)
		{
			_signInManager = signInManager;
			_userManager = userManager;
		}
		public async void OnGet()
        {
            //https://learn.microsoft.com/en-us/dotnet/api/microsoft.aspnetcore.identity.usermanager-1?view=aspnetcore-8.0

            var user = await _userManager.GetUserAsync(User);
            await _userManager.DeleteAsync(user);

            await _signInManager.SignOutAsync();


			HttpContext.Session.Remove("userID");
            HttpContext.Session.Remove("searchTerm");
			HttpContext.Session.Remove("collectionID");

		}
    }
}
