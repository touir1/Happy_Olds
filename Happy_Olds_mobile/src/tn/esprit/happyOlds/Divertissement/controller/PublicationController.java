/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.controller;

import com.codename1.io.ConnectionRequest;
import com.codename1.io.NetworkManager;
import com.fasterxml.jackson.core.JsonProcessingException;
import java.util.logging.Level;
import java.util.logging.Logger;
import static tn.esprit.happyOlds.Divertissement.controller.CustomController.serverUrl;
import tn.esprit.happyOlds.Divertissement.entity.Groupe;
import tn.esprit.happyOlds.Divertissement.entity.Publication;

/**
 *
 * @author touir
 */
public class PublicationController extends CustomController{
    
    public static void sendPublication(Publication publication){
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(serverUrl+"/entertainment/publications/add");  
        con.addArgument("groupe", Integer.toString(publication.getGroupe().getId()));
        con.addArgument("description", publication.getDescription());
        con.addResponseListener(e -> {
            try {
                String json=new String(con.getResponseData());
                System.out.println(json);
            } catch (Exception ex) {
                System.out.println(ex.getMessage());
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
    }
}
