/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Gui;

import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author SadfiAmine
 */
public class login {
    Form f;
    TextField Username;
    TextField Password;
    Button connexion;
   

    public login() {
         f = new Form("Happy olds ");
         Username = new TextField("", "Name");
         Password = new TextField("", "Password");
         connexion = new Button("connexion");
         f.add(Username);
         f.add(Password);
         f.add(connexion);
         connexion.addActionListener(e->{
             UserController Us=new UserController();
             int response=Us.connection(Username.getText(),Password.getText());
             if(response==1){
                 //Dialog.show("c bn", "c bn", "OK", null);
                 Profil p= new Profil();
                 p.getF().show();
             }/*else{
                 Dialog.show("Erreur", "verfier Login\\Mdp", "OK", null);
             }*/
         });
    }

    public Form getF() {
        return f;
    }

    public void setF(Form f) {
        this.f = f;
    }
    
    
}
