/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.controller;

import com.codename1.io.ConnectionRequest;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.fasterxml.jackson.databind.DeserializationFeature;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import tn.esprit.happyOlds.Divertissement.entity.Publication;
import com.fasterxml.jackson.databind.ObjectMapper;

/**
 *
 * @author touir
 */
public class DivertissementController extends CustomController{
    
    
    
    public static List<Publication> getPublications(int index, int pageSize)
    {
        List<Publication> result = new ArrayList<>();
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(serverUrl+"/entertainment/publications/list");  
        con.addArgument("index", Integer.toString(index));
        con.addArgument("page_size", Integer.toString(pageSize));
        con.addResponseListener(e -> {
            try {
                String json=new String(con.getResponseData());
                result.addAll(Utils.mapList(json, Publication.class));
            } catch (Exception ex) {
                System.out.println(ex.getMessage());
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);
        return result;
    }
}
