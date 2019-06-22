/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Services.Gui;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import tn.esprit.happyOlds.Gui.Profil;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.Services.controller.ServicesController;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author SadfiAmine
 */
public class addService {
    Form F1;
    TextArea desc;
    ComboBox<String> autre;
   
    Button Valider;

    public Form getF1() {
        return F1;
    }

    public void setF1(Form F1) {
        this.F1 = F1;
    }
     public void addService(){
          F1 = new Form("Demander un service ");
         //menu 
         menu m=new menu();
         m.addmenu(F1);
         desc = new TextArea("", 5, 5);
         autre = new ComboBox<String>();
         autre.addItem("Faite Vous Livré");
         autre.addItem("Couvoiturge");
         autre.addItem("Autre");
         Valider = new Button("Valider");
         F1.add(desc);
         F1.add(autre);
         F1.add(Valider);
         Valider.addActionListener(e->{
             ServicesController Us=new ServicesController();
             String response=Us.addService(UserController.userConnectee.getId(),desc.getText(),autre.getSelectedItem());
             if(!response.isEmpty()){
                 Dialog.show("Message", "Demande ajoutée", "OK", null);
                Services s=new Services();
                 s.getF().show();
             }/*else{
                 Dialog.show("Erreur", "verfier Login\\Mdp", "OK", null);
             }*/
         });
         F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
              Services s=new Services();
             
                s.getF().show();
          
            });
         F1.show();
    }
          
         
         

}
