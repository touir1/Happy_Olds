/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.entity.controller;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkManager;

import java.util.List;

import java.util.Map;

import tn.esprit.happyOlds.entity.User;

/**
 *
 * @author SadfiAmine
 */
public class UserController {
    public static User userConnectee= new User();
     int response=-1;
     public int connection(String username,String pwd) {
         
        ConnectionRequest con = new ConnectionRequest();// création d'une nouvelle demande de connexion
        String Url = "http://127.0.0.1:8000/api/login" ;// création de l'URL
        con.addArgument("username", username);
        con.addArgument("password", pwd);
        con.setUrl(Url);// Insertion de l'URL de notre demande de connexion

        con.addResponseListener((e) -> {
         
            String str = new String(con.getResponseData());//Récupération de la réponse du serveur
            if (str.equals("Unexpected")==false){
            System.out.println(str);//Affichage de la réponse serveur sur la console
            JSONParser j = new JSONParser();// Instanciation d'un objet JSONParser permettant le parsing du résultat json
            try {
                Map<String, Object> user = j.parseJSON(new CharArrayReader(str.toCharArray()));
               //mazelt fazet date ma3reftch kifeh nrecuperiha
               List role = (List) user.get("roles");
                System.out.println(role);
                Double id=(Double)user.get("userID");
                Double score=(Double)user.get("scorefinal");
                userConnectee.setUsername("username");
                userConnectee.setRole(role.get(0).toString());
                userConnectee.setId(id.intValue());
                userConnectee.setNom(user.get("nom").toString());
                userConnectee.setPrenom(user.get("prenom").toString());
                userConnectee.setScorefinal(score.intValue());
                userConnectee.setJob(user.get("job").toString());
                userConnectee.setVille(user.get("ville").toString());
                if(user.get("file")!=null){
                userConnectee.setFile(user.get("file").toString());}
                if(user.get("path")!=null){
                userConnectee.setPath(user.get("path").toString());}
                
               response=1;
                }catch (Exception ex) {
                    System.out.println(ex.getMessage());
                }}

            

        });
        NetworkManager.getInstance().addToQueueAndWait(con);// Ajout de notre demande de connexion à la file d'attente du NetworkManager
        return response;
     }
 
}
