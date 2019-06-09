/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Gui;

import com.codename1.ui.Form;
import tn.esprit.happyOlds.Services.Gui.Services;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author SadfiAmine
 */
public class menu {

    public void  addmenu(Form f) {
         f.getToolbar().addCommandToSideMenu("Profil", null, (e)->{
             Profil p = new Profil();
             p.getF().show();
         });
         f.getToolbar().addCommandToSideMenu("Services", null, (e)->{
             Services S = new Services();
             S.getF().show();
         });
        f.getToolbar().addCommandToSideMenu("Forum Medical", null, (e)->{
            //cnx.show();
        });
        f.getToolbar().addCommandToSideMenu("Evénements", null, (e)->{
            //cnx.show();
        });
        f.getToolbar().addCommandToSideMenu("Chat Room", null, (e)->{
            //cnx.show();
        });
        f.getToolbar().addCommandToSideMenu("Logout", null, (e)->{
            login l = new login();
            
            l.getF().show();
        });
    }
    
}
