/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.Gui;

import com.codename1.io.Log;
import com.codename1.ui.Button;
import com.codename1.ui.Form;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import tn.esprit.happyOlds.Divertissement.controller.DivertissementController;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.MyApplication;

/**
 *
 * @author touir
 */
public class Divertissement {
    private Form form;
    private DivertissementController controller;
    private Resources theme;

    public Divertissement() {
        this.form = new Form("Divertissement");
        new menu().addmenu(this.form);
        
        BoxLayout boxLayout = new BoxLayout(BoxLayout.Y_AXIS);
        form.setLayout(boxLayout);
        
        this.theme = MyApplication.getTheme(); 
        this.controller = new DivertissementController();
        
        form.getToolbar().addCommandToOverflowMenu("créer groupe",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("rechercher groupe",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("mes inscriptions aux groupes",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("Conversations",null,(err)->{
            
        });
        
        
        /*
        Button groupes = new Button("Groupes");
        
        groupes.addActionListener( e -> {
            
        });
        Button chatRoom = new Button("Chat");
        chatRoom.addActionListener( e -> {
            
        });
        
        form.add(groupes);
        form.add(chatRoom);
        */
    }
    
    

    public Form getForm() {
        return form;
    }
}
