/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Medical.Gui;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.layouts.BoxLayout;
import tn.esprit.happyOlds.Medical.controller.MedicalController;
import tn.esprit.happyOlds.Medical.entity.Question;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author Yousra Trabelsi
 */
public class addQuestion {
    Form F1;
    TextField titre;
         TextField text;
         ComboBox<String> sujet;
   
          Button Valider;

    public Form getF1() {
        return F1;
    }

    public void setF1(Form F1) {
        this.F1 = F1;
    }
    
   public addQuestion(){ 
       F1= new Form ("Ajouter une question");
        Container cnt2 = new Container(BoxLayout.y());
         titre  = new TextField("", "titre", 10, TextArea.ANY);
        text  = new TextField("", "Description", 20, TextArea.ANY);
     
         sujet = new ComboBox<String>();
           sujet.addItem("type de question");
         sujet.addItem("ventre");
         sujet.addItem("autre");
        
         Valider = new Button("Valider");
          cnt2.add(sujet);
         cnt2.add(titre);
         cnt2.add(text);
         cnt2.add(Valider);
         Valider.addActionListener(e->{
            if(!sujet.getSelectedItem().equals(sujet.getSelectedItem().equals("Type de question"))&&(!titre.getText().isEmpty())&&(!text.getText().isEmpty())){
                MedicalController Mc=new MedicalController();
                String response=Mc.addQuestion(UserController.userConnectee.getId(),text.getText(),titre.getText(),sujet.getSelectedItem());
                System.out.println(response);
                    if(!response.isEmpty()){
                        Dialog.show("Message", "Question ajoutée", "OK", null);
                       Medical q=new Medical();
                        q.getForm().show();
                    }
             }
            else{
                       Dialog.show("Message", "Verifier les champs ", "OK", null);  
                    }
        });
         F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
               Medical q=new Medical();
                     q.getForm().show();
             
           });
         F1.add(cnt2);
         F1.show();
       
}
}
   
          
           
         
       
        
