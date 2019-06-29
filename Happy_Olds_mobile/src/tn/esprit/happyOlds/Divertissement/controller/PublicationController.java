/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.controller;

import com.codename1.io.ConnectionRequest;
import com.codename1.io.NetworkManager;
import com.fasterxml.jackson.core.JsonProcessingException;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import static tn.esprit.happyOlds.Divertissement.controller.CustomController.serverUrl;
import tn.esprit.happyOlds.Divertissement.entity.Commentaire;
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
    
    public static Publication findPublication(int publicationId){
        DataContainer<Publication> dataContainer = new DataContainer<>();
        // "/entertainment/groups/group"
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(serverUrl+"/entertainment/publications/consult");  
        con.addArgument("id", Integer.toString(publicationId));
        con.addResponseListener(e -> {
            try {
                String json=new String(con.getResponseData());
                System.out.println(json);
                dataContainer.setData(Utils.mapObject(json, Publication.class));
            } catch (Exception ex) {
                System.out.println(ex.getMessage());
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        return dataContainer.getData();
    }

    public static List<Commentaire> getComments(int index, int pageSize, int publicationId) {
        List<Commentaire> result = new ArrayList<>();
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(serverUrl+"/entertainment/comments/list");  
        con.addArgument("publicationId", Integer.toString(publicationId));
        con.addArgument("index", Integer.toString(index));
        con.addArgument("pageSize", Integer.toString(pageSize));
        con.addResponseListener(e -> {
            try {
                String json=new String(con.getResponseData());
                System.out.println(json);
                result.addAll(Utils.mapList(json, Commentaire.class));
            } catch (Exception ex) {
                System.out.println(ex.getMessage());
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        return result;
    }

    public static void sendCommentaire(Commentaire commentaire) {
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(serverUrl+"/entertainment/comments/add");  
        con.addArgument("commentaire", commentaire.getTexte());
        con.addArgument("publication", Integer.toString(commentaire.getPublication().getId()));
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
