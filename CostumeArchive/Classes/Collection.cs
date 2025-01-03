using Microsoft.AspNetCore.Mvc.RazorPages;
using System.Reflection;
using System.ComponentModel.DataAnnotations;
using Microsoft.AspNetCore.Mvc;

namespace CostumeArchive.Classes
{
    public class Collection : PageModel
    {
        public string ID { get; set; }
        public string ownerID { get; set; }
        public string name { get; set; }
        public string location { get; set; }
        public string privacy { get; set; }

        [BindProperty]
        public bool? canAdd { get; set; }
        [BindProperty]
        public bool? canEdit { get; set; }

        [BindProperty]
        public bool? canDelete{ get; set; }

        public List<Dictionary<string, string>> users { get; set; }

		public Collection(string id, string OwnerID, string Name, string Location, string Privacy)
        {
            ID = id;
            ownerID = OwnerID;
            name = Name;
            location = Location;
            privacy = Privacy;
            getUsers();
        }

        public void getUsers()
        {
            string queryString = "SELECT * FROM dbo.[PERMISSION] WHERE collectionID = @0;";
            string[] parameters = { ID };

            users = Database.query(queryString, parameters);

            foreach (Dictionary<string, string> user in users)
            {
                string queryString2 = "SELECT name FROM dbo.[USER] WHERE ID = @0;";
                string[] parameters2 = { user["userID"] };

                List<Dictionary<string, string>> name = Database.query(queryString2, parameters2);
                user.Add("name", name[0]["name"]);
            }
        }
    }
}
