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
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author Yousra Trabelsi
 */
public class addReponse {
     Form F1;


    public Form getF1() {
        return F1;
    }

    public void setF1(Form F1) {
        this.F1 = F1;
    }
 
         TextField text;
         
       
         
    public addReponse(int idq){
          
           F1= new Form ("Ajouter une réponse");
        Container cnt2 = new Container(BoxLayout.y());
        text  = new TextField("", "Description", 20, TextArea.ANY);
     
        
        Button Valider = new Button("Valider");
         
         cnt2.add(text);
         cnt2.add(Valider);
         Valider.addActionListener(e->{
            if((!text.getText().isEmpty())){
                MedicalController Mc=new MedicalController();
                String response=Mc.newReponse(UserController.userConnectee.getId(),idq,text.getText());
                System.out.println(response);
                    if(!response.isEmpty()){
                        Dialog.show("Message", "Réponse ajoutée", "OK", null);
                       Medical q=new Medical();
                        q.getForm().show();
                    }
             }
            else{
                       Dialog.show("Message", "Verifier le champ  ", "OK", null);  
                    }
        });
         F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
               Medical q=new Medical();
                     q.getF().show();
             
           });
         F1.add(cnt2);
         F1.show();
       
}
      }    
         

