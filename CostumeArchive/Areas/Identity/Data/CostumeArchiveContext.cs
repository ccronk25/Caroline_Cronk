using Microsoft.AspNetCore.Identity;
using Microsoft.AspNetCore.Identity.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore;

namespace CostumeArchive.Data;

//https://learn.microsoft.com/en-us/aspnet/core/security/authentication/identity-api-authorization?view=aspnetcore-8.0
//https://learn.microsoft.com/en-us/aspnet/core/security/authentication/scaffold-identity?view=aspnetcore-8.0&tabs=visual-studio
public class CostumeArchiveContext : IdentityDbContext<CostumeArchiveUser>
{
    public CostumeArchiveContext(DbContextOptions<CostumeArchiveContext> options)
        : base(options)
    {
    }
}
