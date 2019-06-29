/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.events.controller;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.l10n.ParseException;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.events.ActionListener;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;
import tn.esprit.happyOlds.entity.User;
import tn.esprit.happyOlds.events.entities.Events;


/**
 *
 * @author Romdhani
 */
public class EventsController {
     int response=-1;
     String resp="";
    public List<Events> getEvents(){
       List<Events>AllEvents= new ArrayList<>(); 
       ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/api/events/all");
        con.addResponseListener(new ActionListener<NetworkEvent>(){
           @Override
           public void actionPerformed(NetworkEvent evt) {
               try {
                   JSONParser json = new JSONParser ();
                   String str = new String(con.getResponseData());
                   Map<String,Object>events = json.parseJSON(new CharArrayReader(new String(con.getResponseData()).toCharArray()));
                   List<Map<String,Object>> list = (List<Map<String,Object>>) events.get("root");
                   for (Map<String,Object> obj:list){
                        Events e = new Events();
                        Double id = (Double)obj.get("id");
                        e.setId(id.intValue());
                        e.setTitre((String)obj.get("titre"));
                        e.setDescription((String)obj.get("description"));
                        e.setFile((String)obj.get("file"));
                        e.setPath((String)obj.get("path"));
                        e.setPrivilege((String)obj.get("privilege"));
                        e.setVille((String)obj.get("ville"));
                        Double nbrParticipant = (Double)obj.get("nbrParticipant");
                        Double nbrDispo = (Double)obj.get("nbrDispo");
                        Double participant = (Double)obj.get("Participant");
                        e.setNbrDispo(nbrDispo.intValue());
                        e.setParticipant(participant.intValue());
                        e.setNbrParticipant(nbrParticipant.intValue());


                        LinkedHashMap<String,Object> dateD = (LinkedHashMap<String,Object>) obj.get("dateDebut");
                        e.setDateDebut(new Date(((Double)dateD.get("timestamp")).intValue()));
                        LinkedHashMap<String,Object> dateF = (LinkedHashMap<String,Object>) obj.get("dateFin");
                        e.setDateFin(new Date(((Double) dateF.get("timestamp")).intValue()));


                        User User = new User() ;
                        LinkedHashMap<String,Object> user = (LinkedHashMap<String,Object>) obj.get("idUser");
                        Double idUser=(Double)user.get("id");
                        Double scoreF=(Double)user.get("scorefinal");
                        User.setId(idUser.intValue());
                        User.setScorefinal(scoreF.intValue());
                        User.setJob(user.get("job").toString());
                        User.setNom(user.get("nom").toString());
                        User.setPrenom(user.get("prenom").toString());
                        User.setRole(user.get("role").toString());
                        User.setVille(user.get("ville").toString());
                        User.setUsername(user.get("username").toString());
                        if(user.get("file")!=null){
                            User.setFile(user.get("file").toString());}
                        if(user.get("path")!=null){
                            User.setPath(user.get("path").toString());}
                        LinkedHashMap<String,Object> dateNaiss = (LinkedHashMap<String,Object>) user.get("dateNaissance");
                        Double Timestamp= (Double)dateNaiss.get("timestamp");
                        Date date = new  Date (Timestamp.intValue());  
                        User.setDate_naissance(date);
                        e.setId_user(User);
                        AllEvents.add(e);
                   }
                   System.out.println(AllEvents);
               } 
               catch (Exception e)
               {e.getMessage();}
           }
            
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
         return AllEvents;
        
    
}
    
    public String addEvent(int idUser,String titre,String description, int nbrParticipant, Date dateDebut, Date dateFin, String privilege, String ville){
   
     ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/api/events/add");
        // ?titre="+titre+"&description="+description+"&nbrParticipant="+nbrParticipant+"&privilege="+privilege+"&ville="+ville+"&user="+idUser
        con.addArgument("titre", titre);
        con.addArgument("description", description);
        con.addArgument("nbrParticipant", Integer.toString(nbrParticipant));
        con.addArgument("privilege", privilege);
        con.addArgument("ville", ville);
        con.addArgument("user", Integer.toString(idUser));
        con.addArgument("deb_year",Integer.toString(dateDebut.getYear()));
        con.addArgument("deb_month",Integer.toString(dateDebut.getMonth()));
        con.addArgument("deb_day",Integer.toString(dateDebut.getDate()));
        con.addArgument("deb_hours",Integer.toString(dateDebut.getHours()));
        con.addArgument("deb_minutes",Integer.toString(dateDebut.getMinutes()));
        con.addArgument("deb_seconds",Integer.toString(dateDebut.getSeconds()));
        con.addArgument("fin_year",Integer.toString(dateDebut.getYear()));
        con.addArgument("fin_month",Integer.toString(dateDebut.getMonth()));
        con.addArgument("fin_day",Integer.toString(dateDebut.getDate()));
        con.addArgument("fin_hours",Integer.toString(dateDebut.getHours()));
        con.addArgument("fin_minutes",Integer.toString(dateDebut.getMinutes()));
        con.addArgument("fin_seconds",Integer.toString(dateDebut.getSeconds()));
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                     resp = new String(con.getResponseData());
                    System.out.println(resp);
                 }
                catch(Exception e){
                e.getMessage();
                }
            }
            }); 
        NetworkManager.getInstance().addToQueueAndWait(con);//pour etablir la conx
    /*     
    } catch (ParseException ex) {
             Logger.getLogger(EventsController.class.getName()).log(Level.SEVERE, null, ex);
         }*/
        return resp;
     }
}
