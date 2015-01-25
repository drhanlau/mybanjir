using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using BanjirModel;
using HtmlAgilityPack;
using MyBanjir;
using Newtonsoft.Json;

namespace MyBanjirWeb
{
    public partial class RiverLevel : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            var state = Request["state"];

            HtmlWeb web = new HtmlWeb();
            var doc = web.Load("http://infobanjir.water.gov.my/waterlevel_page.cfm?state=" + state);

            var rows = doc.DocumentNode.SelectNodes("//tr[@height='30']");
            //var rows = table.SelectNodes("tr");

            List<RiverLevelEntry> results = new List<RiverLevelEntry>();

            foreach (var row in rows)
            {
                var cells = row.SelectNodes("td");

                RiverLevelEntry entry = new RiverLevelEntry();

                entry.StationId = cells[0].InnerText.Clean();
                entry.StationName = cells[1].InnerText.Clean();
                entry.District = cells[2].InnerText.Clean();
                entry.RiverBasin = cells[3].InnerText.Clean();

                try
                {
                    entry.LastUpdateDate = DateTime.Parse(cells[4].InnerText.Clean().Replace("Off-line", "").Replace("-", ""));
                }
                catch (Exception ex)
                {

                    entry.LastUpdateDate = DateTime.Now;
                }

                entry.RiverLevel = Convert.ToDouble(cells[5].InnerText.Clean());
                entry.NormalLevel = Convert.ToDouble(cells[6].InnerText.Clean());
                entry.AlertLevel = Convert.ToDouble(cells[7].InnerText.Clean());
                entry.WarningLevel = Convert.ToDouble(cells[8].InnerText.Clean());
                entry.DangerLevel = Convert.ToDouble(cells[9].InnerText.Clean());

                results.Add(entry);
            }

            string json = JsonConvert.SerializeObject(results);

            Response.Clear();
            Response.ContentType = "application/json";
            Response.AppendHeader("Access-Control-Allow-Origin", "*");

            Response.Write(json);
            Response.End();
        }
    }
}