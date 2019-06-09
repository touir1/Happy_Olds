/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Services.controller;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;

import com.codename1.ui.events.ActionListener;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.List;

import java.util.Map;
import tn.esprit.happyOlds.Services.entity.CommentaireService;
import tn.esprit.happyOlds.Services.entity.Postuler;
import tn.esprit.happyOlds.Services.entity.Service;
import tn.esprit.happyOlds.entity.User;





/**
 *
 * @author SadfiAmine
 */
public class ServicesController {
    int response=-1;
    public List<Service> getServices(){
       List<Service>AllServices= new ArrayList<>(); 
       ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/api/services/service/all");  
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    
                    JSONParser jsonp = new JSONParser();
                    String str=new String(con.getResponseData());
                    Map<String, Object> tasks = jsonp.parseJSON(new CharArrayReader(new String(con.getResponseData()).toCharArray()));
                    
                    List<Map<String, Object>> list = (List<Map<String, Object>>) tasks.get("root");
                     for (Map<String, Object> obj : list) {
                         Service s= new Service();
                         Double idService= (Double)obj.get("id");
                         s.setId(idService.intValue());
                         s.setDescription(obj.get("description").toString());
                        
                         s.setType(obj.get("type").toString());
                         if(obj.get("valider")!=null){
                         s.setValider(obj.get("valider").toString());}
                         LinkedHashMap<String,Object> dateService = (LinkedHashMap<String,Object>) obj.get("date");
                         Double Timestamps= (Double)dateService.get("timestamp");
                         Date dates = new  Date (Timestamps.intValue());  
                         s.setDate(dates);
                         User User = new User();
                         User UserAssociee= new User();
                         List<Postuler> LstPostuler=new ArrayList<>();
                         List<CommentaireService> LstCommentaires=new ArrayList<>();
                       
                        //user
                        LinkedHashMap<String,Object> user = (LinkedHashMap<String,Object>) obj.get("user");
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
                        s.setUser(User);
                          //postuler
                        List<Map<String, Object>> postuler=(List<Map<String, Object>>)obj.get("postuler");
                        for (Map<String, Object> objj : postuler) {
                            Postuler p =new Postuler();
                            Double idP=(Double)objj.get("id");
                            Double idS=(Double)objj.get("service");
                            p.setId(idP.intValue());
                            p.setService(idS.intValue());
                            User UserP = new User();
                            //user Postuler
                             //user
                            LinkedHashMap<String,Object> userP = (LinkedHashMap<String,Object>) objj.get("user");
                            Double idUserP=(Double)userP.get("id");
                            Double scoreFP=(Double)userP.get("scorefinal");
                            UserP.setId(idUserP.intValue());
                            UserP.setScorefinal(scoreFP.intValue());
                            UserP.setJob(userP.get("job").toString());
                            UserP.setNom(userP.get("nom").toString());
                            UserP.setPrenom(userP.get("prenom").toString());
                            UserP.setRole(userP.get("role").toString());
                            UserP.setVille(userP.get("ville").toString());
                            UserP.setUsername(userP.get("username").toString());
                            if(userP.get("file")!=null){
                                UserP.setFile(userP.get("file").toString());}
                            if(userP.get("path")!=null){
                                UserP.setPath(userP.get("path").toString());}
                            LinkedHashMap<String,Object> dateNaissP = (LinkedHashMap<String,Object>) userP.get("dateNaissance");
                            Double TimestampP= (Double)dateNaissP.get("timestamp");
                            Date dateP = new  Date (Timestamp.intValue());  
                            UserP.setDate_naissance(dateP);
                            p.setUser(UserP);
                            LstPostuler.add(p);
                          
                    
                            
                        }
                          //commentaires
                        List<Map<String, Object>> Commentaire=(List<Map<String, Object>>)obj.get("commentaires");
                        for (Map<String, Object> objjj : Commentaire) {
                            CommentaireService Cs=new CommentaireService();
                            if(objjj.get("id")!=null){
                                Double idC=(Double)objjj.get("id");
                                Cs.setId(idC.intValue());
                            }
                            Double idC=(Double)objjj.get("service");
                            Cs.setService(idC.intValue());
                            Cs.setTexte(objjj.get("texte").toString());
                            //user commentaire
                            User UserC=new User();
                            LinkedHashMap<String,Object> userC = (LinkedHashMap<String,Object>) objjj.get("user");
                            Double idUserC=(Double)userC.get("id");
                            Double scoreFC=(Double)userC.get("scorefinal");
                            UserC.setId(idUserC.intValue());
                            UserC.setScorefinal(scoreFC.intValue());
                            UserC.setJob(userC.get("job").toString());
                            UserC.setNom(userC.get("nom").toString());
                            UserC.setPrenom(userC.get("prenom").toString());
                            UserC.setRole(userC.get("role").toString());
                            UserC.setVille(userC.get("ville").toString());
                            UserC.setUsername(userC.get("username").toString());
                            if(userC.get("file")!=null){
                                UserC.setFile(userC.get("file").toString());}
                            if(userC.get("path")!=null){
                                UserC.setPath(userC.get("path").toString());}
                            LinkedHashMap<String,Object> dateNaissC = (LinkedHashMap<String,Object>) userC.get("dateNaissance");
                            Double TimestampC= (Double)dateNaissC.get("timestamp");
                            Date dateC = new  Date (Timestamp.intValue());  
                            UserC.setDate_naissance(dateC);
                            Cs.setUser(UserC);
                            LstCommentaires.add(Cs);
                            
                        }
                     //userAssocie
                    if(obj.get("userAssocie")!=null){
                        User UserA= new User();
                        LinkedHashMap<String,Object> userA = (LinkedHashMap<String,Object>) obj.get("userAssocie");
                        Double idUserA=(Double)userA.get("id");
                        Double scoreFA=(Double)userA.get("scorefinal");
                        UserA.setId(idUserA.intValue());
                        UserA.setScorefinal(scoreFA.intValue());
                        UserA.setJob(userA.get("job").toString());
                        UserA.setNom(userA.get("nom").toString());
                        UserA.setPrenom(userA.get("prenom").toString());
                        UserA.setRole(userA.get("role").toString());
                        UserA.setVille(userA.get("ville").toString());
                        UserA.setUsername(userA.get("username").toString());
                        if(userA.get("file")!=null){
                            UserA.setFile(userA.get("file").toString());}
                        if(userA.get("path")!=null){
                            UserA.setPath(userA.get("path").toString());}
                        LinkedHashMap<String,Object> dateNaissA = (LinkedHashMap<String,Object>) userA.get("dateNaissance");
                        Double TimestampA= (Double)dateNaissA.get("timestamp");
                        Date dateA = new  Date (TimestampA.intValue());  
                        UserA.setDate_naissance(dateA);
                        s.setUserAssocie(UserA);  
                    }
                    s.setPostuler(LstPostuler);
                    s.setCommenatires(LstCommentaires);
                    AllServices.add(s);
                     }
                     System.out.println(AllServices);
                    
                } catch (IOException ex) {
                    System.out.println(ex.getMessage());
                }
               
             
                
              
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
   
          return AllServices;       
        
    }
    
     public Service getService(int id){
    Service s= new Service();
      ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/api/services/service/"+id);  
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                String str=new String(con.getResponseData());
                
                System.out.println(str);
                 JSONParser j = new JSONParser();
                try {
                    Map<String, Object> Service = j.parseJSON(new CharArrayReader(str.toCharArray()));
                    LinkedHashMap<String,Object> obj = (LinkedHashMap<String,Object>) Service;
                    System.out.println(Service);
                    
                         Double idService= (Double)obj.get("id");
                         s.setId(idService.intValue());
                         s.setDescription(obj.get("description").toString());
                        
                         s.setType(obj.get("type").toString());
                         if(obj.get("valider")!=null){
                         s.setValider(obj.get("valider").toString());}
                         LinkedHashMap<String,Object> dateService = (LinkedHashMap<String,Object>) obj.get("date");
                         Double Timestamps= (Double)dateService.get("timestamp");
                         Date dates = new  Date (Timestamps.intValue());  
                         s.setDate(dates);
                         User User = new User();
                         User UserAssociee= new User();
                         List<Postuler> LstPostuler=new ArrayList<>();
                         List<CommentaireService> LstCommentaires=new ArrayList<>();
                       
                        //user
                        LinkedHashMap<String,Object> user = (LinkedHashMap<String,Object>) obj.get("user");
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
                        s.setUser(User);
                          //postuler
                        List<Map<String, Object>> postuler=(List<Map<String, Object>>)obj.get("postuler");
                        for (Map<String, Object> objj : postuler) {
                            Postuler p =new Postuler();
                            Double idP=(Double)objj.get("id");
                            Double idS=(Double)objj.get("service");
                            p.setId(idP.intValue());
                            p.setService(idS.intValue());
                            User UserP = new User();
                            //user Postuler
                             //user
                            LinkedHashMap<String,Object> userP = (LinkedHashMap<String,Object>) objj.get("user");
                            Double idUserP=(Double)userP.get("id");
                            Double scoreFP=(Double)userP.get("scorefinal");
                            UserP.setId(idUserP.intValue());
                            UserP.setScorefinal(scoreFP.intValue());
                            UserP.setJob(userP.get("job").toString());
                            UserP.setNom(userP.get("nom").toString());
                            UserP.setPrenom(userP.get("prenom").toString());
                            UserP.setRole(userP.get("role").toString());
                            UserP.setVille(userP.get("ville").toString());
                            UserP.setUsername(userP.get("username").toString());
                            if(userP.get("file")!=null){
                                UserP.setFile(userP.get("file").toString());}
                            if(userP.get("path")!=null){
                                UserP.setPath(userP.get("path").toString());}
                            LinkedHashMap<String,Object> dateNaissP = (LinkedHashMap<String,Object>) userP.get("dateNaissance");
                            Double TimestampP= (Double)dateNaissP.get("timestamp");
                            Date dateP = new  Date (Timestamp.intValue());  
                            UserP.setDate_naissance(dateP);
                            p.setUser(UserP);
                            LstPostuler.add(p);
                          
                    
                            
                        }
                          //commentaires
                        List<Map<String, Object>> Commentaire=(List<Map<String, Object>>)obj.get("commentaires");
                        for (Map<String, Object> objjj : Commentaire) {
                            CommentaireService Cs=new CommentaireService();
                            if(objjj.get("id")!=null){
                                Double idC=(Double)objjj.get("id");
                                Cs.setId(idC.intValue());
                            }
                            Double idC=(Double)objjj.get("service");
                            Cs.setService(idC.intValue());
                            Cs.setTexte(objjj.get("texte").toString());
                            //user commentaire
                            User UserC=new User();
                            LinkedHashMap<String,Object> userC = (LinkedHashMap<String,Object>) objjj.get("user");
                            Double idUserC=(Double)userC.get("id");
                            Double scoreFC=(Double)userC.get("scorefinal");
                            UserC.setId(idUserC.intValue());
                            UserC.setScorefinal(scoreFC.intValue());
                            UserC.setJob(userC.get("job").toString());
                            UserC.setNom(userC.get("nom").toString());
                            UserC.setPrenom(userC.get("prenom").toString());
                            UserC.setRole(userC.get("role").toString());
                            UserC.setVille(userC.get("ville").toString());
                            UserC.setUsername(userC.get("username").toString());
                            if(userC.get("file")!=null){
                                UserC.setFile(userC.get("file").toString());}
                            if(userC.get("path")!=null){
                                UserC.setPath(userC.get("path").toString());}
                            LinkedHashMap<String,Object> dateNaissC = (LinkedHashMap<String,Object>) userC.get("dateNaissance");
                            Double TimestampC= (Double)dateNaissC.get("timestamp");
                            Date dateC = new  Date (Timestamp.intValue());  
                            UserC.setDate_naissance(dateC);
                            Cs.setUser(UserC);
                            LstCommentaires.add(Cs);
                            
                        }
                     //userAssocie
                    if(obj.get("userAssocie")!=null){
                        User UserA= new User();
                        LinkedHashMap<String,Object> userA = (LinkedHashMap<String,Object>) obj.get("userAssocie");
                        Double idUserA=(Double)userA.get("id");
                        Double scoreFA=(Double)userA.get("scorefinal");
                        UserA.setId(idUserA.intValue());
                        UserA.setScorefinal(scoreFA.intValue());
                        UserA.setJob(userA.get("job").toString());
                        UserA.setNom(userA.get("nom").toString());
                        UserA.setPrenom(userA.get("prenom").toString());
                        UserA.setRole(userA.get("role").toString());
                        UserA.setVille(userA.get("ville").toString());
                        UserA.setUsername(userA.get("username").toString());
                        if(userA.get("file")!=null){
                            UserA.setFile(userA.get("file").toString());}
                        if(userA.get("path")!=null){
                            UserA.setPath(userA.get("path").toString());}
                        LinkedHashMap<String,Object> dateNaissA = (LinkedHashMap<String,Object>) userA.get("dateNaissance");
                        Double TimestampA= (Double)dateNaissA.get("timestamp");
                        Date dateA = new  Date (TimestampA.intValue());  
                        UserA.setDate_naissance(dateA);
                        s.setUserAssocie(UserA);  
                    }
                    s.setPostuler(LstPostuler);
                    s.setCommenatires(LstCommentaires);
                    System.out.println(s);
                   
                } catch (Exception ex) {
                    System.out.println(ex.getMessage());
                }
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        return s;
    }
}
 