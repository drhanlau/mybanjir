using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using BanjirModel;
using Newtonsoft.Json;
using System.IO.Compression;

namespace MyBanjirWeb
{

    public partial class news : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            BanjirEntities db = new BanjirEntities();

            string json = JsonConvert.SerializeObject(db.Items.OrderByDescending(p => p.ID).Take(100));

            Response.Clear();   
            Response.ContentType = "application/json";
            string acceptEncoding = Request.Headers["Accept-Encoding"] ?? "";
            if (acceptEncoding.IndexOf("gzip",
                StringComparison.OrdinalIgnoreCase) > -1)
            {
                // Read the response using a GZip compressor ,
                //    and replace the output with compressed result
                Response.Filter = new GZipStream(
                        Response.Filter, CompressionMode.Compress);
                // Tell the client the ouput they got is compressed in GZip
                Response.AppendHeader("Content-Encoding", "gzip");
            }
            
            Response.AppendHeader("Access-Control-Allow-Origin", "*");

            Response.Write(json);
            Response.End();
        }
    }
}