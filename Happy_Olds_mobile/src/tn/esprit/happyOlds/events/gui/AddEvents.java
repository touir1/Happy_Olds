/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Events.Gui;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.spinner.Picker;
import java.util.Date;
import tn.esprit.happyOlds.controller.UserController;
import tn.esprit.happyOlds.events.controller.EventsController;

/**
 *
 * @author SadfiAmine
 */
public class AddEvents {

    Form F1;
    TextField desc;
    ComboBox<String> autre;
    TextField lbltitle;
    TextField lblnbrParticipant;
    TextField lblprivilege;
    TextField lblville;
    Picker dateDebut;
    Picker dateFin;
    Button Valider;

    public Form getF1() {
        return F1;
    }

    public void setF1(Form F1) {
        this.F1 = F1;
    }

    public AddEvents() {
        F1 = new Form(" Ajouter un événement ");
      
        Container cnt2 = new Container(BoxLayout.y());
        lbltitle = new TextField("");
        desc = new TextField("", "Description", 20, TextArea.ANY);
         lblnbrParticipant = new TextField("", "nbrParticipant");
         lblprivilege = new TextField("","lieu");
      
         dateDebut = new Picker();
        dateDebut.setType(Display.PICKER_TYPE_DATE_AND_TIME);
        dateDebut.setDate(new Date());
        
        dateFin = new Picker();
        dateFin.setType(Display.PICKER_TYPE_DATE_AND_TIME);
        dateFin.setDate(new Date());
        
        autre = new ComboBox<String>();
        autre.addItem("Choisissez ville");
        autre.addItem("Tunis");
        autre.addItem("Ariana");
        autre.addItem("Ben Arous");
        autre.addItem("Béja");
        autre.addItem("Bizerte");
        autre.addItem("Gabes");
        autre.addItem("Jandouba");
        autre.addItem("Gafsa");
        autre.addItem("Kairouan");
        autre.addItem("kasserine");
        autre.addItem("Kebili");
        autre.addItem("La manouba");
        autre.addItem("le kef");
        autre.addItem("Mahdia");
        autre.addItem("Médenine");
        autre.addItem("Monastir");
        autre.addItem("Nabeul");
        autre.addItem("Sfax");
        autre.addItem("Sidi Bouzid");
        autre.addItem("Siliana");
        autre.addItem("Sousse");
        autre.addItem("Tataouine");
        autre.addItem("Tozeur");
        autre.addItem("Zaghouan");
        autre.addItem("Faite Vous Livré");
        autre.addItem("Couvoiturge");
        autre.addItem("Autre");
        Valider = new Button("Valider");
       
        cnt2.add(lbltitle);
         cnt2.add(desc);
        cnt2.add(lblnbrParticipant);
        cnt2.add(lblprivilege);
        cnt2.add(dateDebut);
        cnt2.add(dateFin);
        cnt2.add(autre);
       
        cnt2.add(Valider);
        Valider.addActionListener(e -> {
            if (!autre.getSelectedItem().equals(autre.getSelectedItem().equals("Choisissez ville")) && (!desc.getText().isEmpty())) {
                EventsController Us = new EventsController();
                String response = Us.addEvent(UserController.userConnectee.getId(),lbltitle.getText(),desc.getText(), Integer.valueOf(lblnbrParticipant.getText()), dateDebut.getDate(), dateFin.getDate(), lblprivilege.getText(),   autre.getSelectedItem());
                System.out.println(response);
                if (!response.isEmpty()) {
                    Dialog.show("Message", "événement ajoutée", "OK", null);
                    EventsAffiche s = new EventsAffiche();
                    s.getF().show();
                }/*else{
                        Dialog.show("Erreur", "verfier Login\\Mdp", "OK", null);
                    }*/
            } else {
                Dialog.show("Message", "Verifier les champs ", "OK", null);
            }
        });
        F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
            EventsAffiche s = new EventsAffiche();

            s.getF().show();

        });
        F1.add(cnt2);
        F1.show();
    }

}
