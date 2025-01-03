using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Identity;
using CostumeArchive.Classes;

namespace CostumeArchive.Data;

//https://learn.microsoft.com/en-us/aspnet/core/security/authentication/scaffold-identity?view=aspnetcore-8.0&tabs=visual-studio
//https://learn.microsoft.com/en-us/aspnet/core/security/authentication/add-user-data?view=aspnetcore-8.0&tabs=visual-studio

// Add profile data for application users by adding properties to the CostumeArchiveUser class
public class CostumeArchiveUser : IdentityUser
{
    [PersonalData]
    public string userID { get; set; }

    public string? collectionID { get; set; }
    public string? searchTerm { get; set; }

	public CostumeArchiveUser() {	}
    public CostumeArchiveUser(string username)
    {
        UserName = username;
        userID = getID();
    }

    public void findID()
    {
        userID = getID();
    }
    public string getID()
    {
        string userID = string.Empty;

        string queryString = "SELECT ID FROM dbo.[USER] WHERE name = @0;";
        string[] parameters = { UserName };

        List<Dictionary<string, string>> result = Database.query(queryString, parameters);

        if (result.Count > 0 )
        {
            userID = result[0]["ID"];
        }

        return userID;
    }
}

