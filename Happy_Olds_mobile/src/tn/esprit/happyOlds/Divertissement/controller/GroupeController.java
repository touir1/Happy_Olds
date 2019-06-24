/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.controller;

import com.codename1.io.ConnectionRequest;
import com.codename1.io.NetworkManager;
import tn.esprit.happyOlds.Divertissement.entity.Groupe;

/**
 *
 * @author touir
 */
public class GroupeController extends CustomController{
    
    public static Groupe findGroupe(int id){
        DataContainer<Groupe> dataContainer = new DataContainer<>();
        // "/entertainment/groups/group"
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(serverUrl+"/entertainment/groups/group");  
        con.addArgument("id", Integer.toString(id));
        con.addResponseListener(e -> {
            try {
                String json=new String(con.getResponseData());
                dataContainer.setData(Utils.mapObject(json, Groupe.class));
            } catch (Exception ex) {
                System.out.println(ex.getMessage());
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        return dataContainer.getData();
    }
}