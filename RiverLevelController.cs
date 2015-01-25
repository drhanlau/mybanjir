using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;
using System.Web.Http.Cors;
using BanjirModel;
using HtmlAgilityPack;
using MyBanjir;

namespace MyBanjirWeb
{

    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class RiverLevelController : ApiController
    {
        // GET api/<controller>
        public string Get()
        {
            //return new string[] { "value1", "value2" };
            HtmlWeb web = new HtmlWeb();
            try
            {
                var doc = web.Load("http://infobanjir.water.gov.my/waterlevel_page.cfm?state=KEL");                
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

                    entry.LastUpdateDate = DateTime.Parse(cells[4].InnerText.Clean().Replace("Off-line", "").Replace("-", ""));
                    entry.RiverLevel = Convert.ToDouble(cells[5].InnerText.Clean());
                    entry.NormalLevel = Convert.ToDouble(cells[6].InnerText.Clean());
                    entry.AlertLevel = Convert.ToDouble(cells[7].InnerText.Clean());
                    entry.WarningLevel = Convert.ToDouble(cells[8].InnerText.Clean());
                    entry.DangerLevel = Convert.ToDouble(cells[9].InnerText.Clean());

                    results.Add(entry);
                }
            }
            catch (Exception ex)
            {
                return ex.Message;
            }

            return "ok";

        }

        //// GET api/<controller>/5
        //public string Get(int id)
        //{
        //    return "value";
        //}

        public IEnumerable<RiverLevelEntry> Get(string id)
        {
            //return "value - " + id;

             HtmlWeb web = new HtmlWeb();
            var doc = web.Load("http://infobanjir.water.gov.my/waterlevel_page.cfm?state=" + id);

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

            return results;
        }


        // POST api/<controller>
        public void Post([FromBody]string value)
        {
        }

        // PUT api/<controller>/5
        public void Put(int id, [FromBody]string value)
        {
        }

        // DELETE api/<controller>/5
        public void Delete(int id)
        {
        }
    }
}