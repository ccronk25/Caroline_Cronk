using Microsoft.IdentityModel.Tokens;
using System.Security.Cryptography;
using System.Text.RegularExpressions;

namespace CostumeArchive.Classes
{
    public class Costume
    {
		public static string imgPath = "~/img/costume_images/";
		public string id { get; set; }
        public string title { get; set; }
        public string collectionID { get; set; }
        public string location { get; set; }
        public string category { get; set; }
        public string notes { get; set; }
        public string imgName { get; set; }
        public Dictionary<string, string> measurements { get; set; }

        public List<string> colors { get; set; }
        public int eraStart { get; set; }
        public int eraEnd { get; set; }
        public List<string> tags { get; set; }

        public Costume(string ID, string Title, string collID, string Location, string Category, string Notes, string imgSource)
        {
            id = ID;
            title = Title;
            collectionID = collID;
            location = Location;
            category = Category;
            notes = Notes;
            imgName = imgSource;
            colors = new List<string>();
            tags = new List<string>();
            measurements = new Dictionary<string, string>();
            getMeasurements();
            getColors();
            getEra();
        }

        public Costume(string ID, string Title, string collID, string Location, string Category, string Notes, List<string> Tags, List<string> Colors, Dictionary<string, string> Measurements)
        {
            id = ID;
            title = Title;
            collectionID = collID;
            location = Location;
            category = Category;
            notes = Notes;
            tags = Tags;
            colors = Colors;
            measurements = Measurements;
        }

        private void getMeasurements()
        {
            string selectCommand = "SELECT * FROM dbo.[MEASUREMENT] WHERE costumeID = @0;";
            string[] parameters = { id };
            List<Dictionary<string, string>> result = Database.query(selectCommand, parameters);

            if (result.Count > 0)
            {
                Dictionary<string, string> currentEntry = result[0];
                foreach (KeyValuePair<string, string> kvp in currentEntry)
                {
                    if (kvp.Key != "costumeID" && kvp.Value != null && kvp.Value != "")
                    {
                        //make keys pretty by replacing capitals with a space and a lowercase and making the first character capitalized
                        string key = Regex.Replace(kvp.Key, "([A-Z])", " $1");
                        key = key.Substring(0, 1).ToUpper() + key.Substring(1, key.Length - 1).ToLower();

                        //https://stackoverflow.com/questions/2403621/c-sharp-replace-every-uppercase-letter-with-underscore-and-the-letter
                        //https://stackoverflow.com/questions/10286252/format-string-with-regex-in-c-sharp

                        measurements.Add(key, kvp.Value);
                    }
                    //https://learn.microsoft.com/en-us/dotnet/api/system.collections.generic.dictionary-2?view=net-8.0
                }
            }
        }

        private void getColors()
        {
            string selectCommand = "SELECT * FROM dbo.[COLOR] WHERE costumeID = @0;";
            string[] parameters = { id };
            List<Dictionary<string, string>> result = Database.query(selectCommand, parameters);

            if (result.Count > 0)
            {
                Dictionary<string, string> currentEntry = result[0];
                foreach (KeyValuePair<string, string> kvp in currentEntry)
                {
                    if (kvp.Key != "costumeID" && kvp.Value != null)
                    {
                        colors.Add(kvp.Value);
                    }
                    //https://learn.microsoft.com/en-us/dotnet/api/system.collections.generic.dictionary-2?view=net-8.0
                }
            }
        }

        private void getEra()
        {
            string selectCommand = "SELECT * FROM dbo.[ERA] WHERE costumeID = @0;";
            string[] parameters = { id };
            List<Dictionary<string, string>> result = Database.query(selectCommand, parameters);

            if (result.Count > 0)
            {
                //https://learn.microsoft.com/en-us/dotnet/csharp/programming-guide/types/how-to-convert-a-string-to-a-number
                Dictionary<string, string> currentEntry = result[0];
                if (!string.IsNullOrEmpty(currentEntry["start"]))
                {
                    eraStart = int.Parse(currentEntry["start"]);
                }
                if (!string.IsNullOrEmpty(currentEntry["end"]))
                {
                    eraEnd = int.Parse(currentEntry["end"]);
                }
            }
        }
    }
}
