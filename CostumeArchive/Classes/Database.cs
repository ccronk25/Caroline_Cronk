using Newtonsoft.Json.Linq;
using System.Data.SqlClient;

namespace CostumeArchive.Classes
{
    public class Database
    {
        //creates a new database connection
        static SqlConnection getConnect()
        {
            SqlConnection conn = new SqlConnection("Server=DESKTOP-KRCQ27P\\SQLEXPRESS;Database=CostumeArchive;Integrated Security=True;");
            return conn;
        }

        public static List<Dictionary<string, string>> query(string queryString, string[] parameters) //parameter array of all values you want to pass in - field name and value
        {

            SqlConnection conn = getConnect();
            SqlCommand command = new SqlCommand(queryString, conn);

            for (int i = 0; i < parameters.Length; i++)
            {
                //https://stackoverflow.com/questions/13451085/exception-when-addwithvalue-parameter-is-null
                if (parameters[i] == null)
                {
                    command.Parameters.AddWithValue("@" + i, DBNull.Value);
                }
                else
                {
                    command.Parameters.AddWithValue("@" + i, parameters[i]);
                }
               
            }

            List<Dictionary<string, string>> result = new List<Dictionary<string, string>>();

            conn.Open();

            if (!queryString.Contains("SELECT"))
            {
                //https://stackoverflow.com/questions/19956533/sql-insert-query-using-c-sharp
                command.ExecuteNonQuery();
            }
            else
            {
                using (SqlDataReader reader = command.ExecuteReader())
                {
                    while (reader.Read())
                    {
                        Dictionary<string, string> entry = new Dictionary<string, string>();
                        for (int i = 0; i < reader.FieldCount; i++)
                        {
                            entry.Add(reader.GetName(i), reader[i].ToString().Trim());
                        }
                        result.Add(entry);
                    }
                }
            }

            conn.Close();

            return result;
        }
    }
}


//Sources:
//https://stackoverflow.com/questions/14270082/connection-string-using-windows-authentication
//https://stackoverflow.com/questions/22803975/connection-to-sql-server-express-from-c-sharp
//https://stackoverflow.com/questions/43744134/how-to-read-each-row-and-value-with-sqlcommand-in-c
//https://learn.microsoft.com/en-us/dotnet/api/system.data.sqlclient.sqlcommand?view=dotnet-plat-ext-8.0
//https://learn.microsoft.com/en-us/dotnet/api/system.data.sqlclient.sqldatareader?view=dotnet-plat-ext-8.0
//https://learn.microsoft.com/en-us/dotnet/api/system.collections.generic.dictionary-2?view=net-8.0