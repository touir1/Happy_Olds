/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Services.Gui;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.layouts.BoxLayout;
import tn.esprit.happyOlds.Gui.Profil;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.Services.controller.ServicesController;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author SadfiAmine
 */
public class AddService {
    Form F1;
    TextField desc;
    ComboBox<String> autre;
   
    Button Valider;

    public Form getF1() {
        return F1;
    }

    public void setF1(Form F1) {
        this.F1 = F1;
    }
     public AddService(){
          F1 = new Form("Demander un service ");
         //menu 
        Container cnt2 = new Container(BoxLayout.y());
        desc  = new TextField("", "Description", 20, TextArea.ANY);
      
         autre = new ComboBox<String>();
         autre.addItem("Type demande");
         autre.addItem("Faite Vous Livré");
         autre.addItem("Couvoiturge");
         autre.addItem("Autre");
         Valider = new Button("Valider");
          cnt2.add(autre);
         cnt2.add(desc);
         cnt2.add(Valider);
         Valider.addActionListener(e->{
            if(!autre.getSelectedItem().equals(autre.getSelectedItem().equals("Type demande"))&&(!desc.getText().isEmpty())){
                ServicesController Us=new ServicesController();
                String response=Us.addService(UserController.userConnectee.getId(),desc.getText(),autre.getSelectedItem().replace("é", "e"));
                System.out.println(response);
                    if(!response.isEmpty()){
                        Dialog.show("Message", "Demande ajoutée", "OK", null);
                       Services s=new Services();
                        s.getF().show();
                    }/*else{
                        Dialog.show("Erreur", "verfier Login\\Mdp", "OK", null);
                    }*/
             }
            else{
                       Dialog.show("Message", "Verifier les champs ", "OK", null);  
                    }
        });
         F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
              Services s=new Services();
             
                s.getF().show();
          
            });
         F1.add(cnt2);
         F1.show();
    }
          
         
         

}
