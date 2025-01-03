using Microsoft.AspNetCore.Identity;
using Microsoft.EntityFrameworkCore;
using CostumeArchive.Data;

var builder = WebApplication.CreateBuilder(args);
//var connectionString = builder.Configuration.GetConnectionString("CostumeArchiveContextConnection") ?? throw new InvalidOperationException("Connection string 'CostumeArchiveContextConnection' not found.");

//https://learn.microsoft.com/en-us/aspnet/core/security/authentication/identity-api-authorization?view=aspnetcore-8.0
builder.Services.AddDbContext<CostumeArchiveContext>(
    options => options.UseInMemoryDatabase("AppDb"));

builder.Services.AddDefaultIdentity<CostumeArchiveUser>(options => options.SignIn.RequireConfirmedAccount = true).AddEntityFrameworkStores<CostumeArchiveContext>();

// Add services to the container.
builder.Services.AddRazorPages();

builder.Services.AddSession(options =>
{
    options.IdleTimeout = TimeSpan.FromSeconds(10);
    options.Cookie.HttpOnly = true;
    options.Cookie.IsEssential = true;
});

var app = builder.Build();

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Error");
    // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
    app.UseHsts();
}

app.UseHttpsRedirection();
app.UseStaticFiles();

app.UseRouting();

app.UseAuthorization();

app.UseSession();

app.MapRazorPages();

app.Run();
