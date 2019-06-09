/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Gui;

import com.codename1.ui.Form;

/**
 *
 * @author SadfiAmine
 */
public class Profil {
     Form f;

    public Profil() {
        f = new Form("Profil");
      
        //menu 
        menu m=new menu();
        m.addmenu(f);
    }

    public Form getF() {
        return f;
    }

    public void setF(Form f) {
        this.f = f;
    }
     
}
