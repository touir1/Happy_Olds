/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Medical.controller;

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
import tn.esprit.happyOlds.Medical.entity.Question;
import tn.esprit.happyOlds.Medical.entity.Reponse;
import tn.esprit.happyOlds.entity.User;
/**
 *
 * @author Yousra Trabelsi
 */
public class MedicalController {
 int response=-1;
 String resp="";
    public List<Question> getQuestion(){
       List<Question>AllQuestion= new ArrayList<>(); 
       ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/api/medical/all");  
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                    
                    JSONParser jsonp = new JSONParser();
                    String str=new String(con.getResponseData());
                    Map<String, Object> tasks = jsonp.parseJSON(new CharArrayReader(new String(con.getResponseData()).toCharArray()));
                    
                    List<Map<String, Object>> list = (List<Map<String, Object>>) tasks.get("root");
                     for (Map<String, Object> obj : list) {
                         Question q= new Question();
                         Double idQuestion= (Double)obj.get("id");
                         q.setId(idQuestion.intValue());
                         q.setTitre(obj.get("titre").toString());
                         q.setDescription(obj.get("text").toString());
                      
                       
                         LinkedHashMap<String,Object> dateQuestion = (LinkedHashMap<String,Object>) obj.get("dateQ");
                         Double Timestamps= (Double)dateQuestion.get("timestamp");
                         Date dates = new  Date (Timestamps.intValue());  
                         q.setDateQ(dates);
                         User User = new User();
               
                         List<Reponse> LstReponse=new ArrayList<>();
                       
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
                        q.setUser(User);
                        
                        //reponse
                        
                        List<Map<String, Object>> reponse=(List<Map<String, Object>>)obj.get("reponses");
                        if (reponse != null){
                        for (Map<String, Object> objj : reponse) {
                            Reponse r =new Reponse();
                            Double idR=(Double)objj.get("id");
                            Double idQ=(Double)objj.get("question");
                            String textrep=objj.get("text").toString();
                            r.setId(idR.intValue());
                            r.setText(textrep);
                            r.setQuestion(idQ.intValue());
                           
                            User UserR = new User();
                            //user reponse
                             //user
                            LinkedHashMap<String,Object> userR = (LinkedHashMap<String,Object>) objj.get("user");
                            Double idUserR=(Double)userR.get("id");
                            Double scoreFP=(Double)userR.get("scorefinal");
                            UserR.setId(idUserR.intValue());
                            UserR.setScorefinal(scoreFP.intValue());
                            UserR.setJob(userR.get("job").toString());
                            UserR.setNom(userR.get("nom").toString());
                            UserR.setPrenom(userR.get("prenom").toString());
                            UserR.setRole(userR.get("role").toString());
                            UserR.setVille(userR.get("ville").toString());
                            UserR.setUsername(userR.get("username").toString());
                            if(userR.get("file")!=null){
                                UserR.setFile(userR.get("file").toString());}
                            if(userR.get("path")!=null){
                                UserR.setPath(userR.get("path").toString());}
                            LinkedHashMap<String,Object> dateNaissR = (LinkedHashMap<String,Object>) userR.get("dateNaissance");
                            Double TimestampR= (Double)dateNaissR.get("timestamp");
                            Date dateR = new  Date (Timestamp.intValue());  
                            UserR.setDate_naissance(dateR);
                            r.setUser(UserR);
                            LstReponse.add(r);}}
                        
                          q.setReponse(LstReponse);
                       AllQuestion.add(q);
                 
                     }
                     System.out.println(AllQuestion);
                    
                } catch (IOException ex) {
                    System.out.println(ex.getMessage());
                }
                            
                        }

     });
        NetworkManager.getInstance().addToQueueAndWait(con);
   
          return AllQuestion; 
    
}
      public Question getQuestion(int id){
    Question q= new Question();
      ConnectionRequest con = new ConnectionRequest();
        con.setUrl("http://127.0.0.1:8000/api/medical/"+id);  
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                String str=new String(con.getResponseData());
                
                System.out.println(str);
                 JSONParser j = new JSONParser();
                try {
                    Map<String, Object> Question = j.parseJSON(new CharArrayReader(str.toCharArray()));
                    LinkedHashMap<String,Object> obj = (LinkedHashMap<String,Object>) Question;
                    System.out.println(Question);
                    
                         Double idQuestion= (Double)obj.get("id");
                         q.setId(idQuestion.intValue());
                         q.setTitre(obj.get("titre").toString());
                         q.setDescription(obj.get("text").toString());
                        
                      
                         LinkedHashMap<String,Object> dateQuestion = (LinkedHashMap<String,Object>) obj.get("date");
                         Double Timestamps= (Double)dateQuestion.get("timestamp");
                         Date dates = new  Date (Timestamps.intValue());  
                         q.setDateQ(dates);
                         User User = new User();
                       
                         List<Reponse> LstReponse=new ArrayList<>();
                    
                       
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
                        q.setUser(User);
                          //reponse
                        List<Map<String, Object>> reponse=(List<Map<String, Object>>)obj.get("reponses");
                        for (Map<String, Object> objj : reponse) {
                            Reponse r =new Reponse();
                            
                           
                            Double idR=(Double)objj.get("id");
                            Double idQ=(Double)objj.get("question");
                            r.setId(idR.intValue());
                            r.setQuestion(idQ.intValue());
                            
                            User UserR = new User();
                            //user reponse
                             //user
                            LinkedHashMap<String,Object> userR = (LinkedHashMap<String,Object>) objj.get("user");
                            Double idUserR=(Double)userR.get("id");
                            Double scoreFP=(Double)userR.get("scorefinal");
                            UserR.setId(idUserR.intValue());
                            UserR.setScorefinal(scoreFP.intValue());
                            UserR.setJob(userR.get("job").toString());
                            UserR.setNom(userR.get("nom").toString());
                            UserR.setPrenom(userR.get("prenom").toString());
                            UserR.setRole(userR.get("role").toString());
                            UserR.setVille(userR.get("ville").toString());
                            UserR.setUsername(userR.get("username").toString());
                            if(userR.get("file")!=null){
                                UserR.setFile(userR.get("file").toString());}
                            if(userR.get("path")!=null){
                                UserR.setPath(userR.get("path").toString());}
                            LinkedHashMap<String,Object> dateNaissR = (LinkedHashMap<String,Object>) userR.get("dateNaissance");
                            Double TimestampR= (Double)dateNaissR.get("timestamp");
                            Date dateR = new  Date (Timestamp.intValue());  
                            UserR.setDate_naissance(dateR);
                            r.setUser(UserR);
                            LstReponse.add(r);
                          
                    
                            
                        }
                          
                     
                    q.setReponse(LstReponse);
                   
                    System.out.println(q);
                   
                } catch (Exception ex) {
                    System.out.println(ex.getMessage());
                }
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        return q;
    }

       public String addQuestion(int idUser,String text,String titre,String sujet){
        
      ConnectionRequest con = new ConnectionRequest();
           System.out.println(idUser);
           System.out.println(text);
           System.out.println(titre);
           System.out.println(sujet);
        con.setUrl("http://127.0.0.1:8000/api/medical/add/add?user="+idUser+"&sujet="+sujet+"&titre="+titre+"&text="+text); 
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                     resp = new String(con.getResponseData());
                    //System.out.println(resp);
                 }
                catch(Exception e){
                e.getMessage();
                }
            }
            }); 
        NetworkManager.getInstance().addToQueueAndWait(con);//pour etablir la conx
        return resp;
     }
       
     public String newReponse(int idUser,int question,String text){
        
      ConnectionRequest con = new ConnectionRequest();
           System.out.println(idUser);
           System.out.println(question);
           System.out.println(text);
       
        con.setUrl("http://127.0.0.1:8000/api/medical/new/new"); 
        con.addArgument("idUser", Integer.toString(idUser));
        con.addArgument("idQuestion", Integer.toString(question));
        con.addArgument("text", text);
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                try {
                     resp = new String(con.getResponseData());
                    //System.out.println(resp);
                 }
                catch(Exception e){
                e.getMessage();
                }
            }
            }); 
        NetworkManager.getInstance().addToQueueAndWait(con);//pour etablir la conx
        return resp;
     }  
}
                
