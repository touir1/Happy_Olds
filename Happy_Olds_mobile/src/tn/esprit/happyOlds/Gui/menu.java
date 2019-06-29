/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Gui;

import com.codename1.ui.Form;
import tn.esprit.happyOlds.Divertissement.Gui.DivertissementGui;
import tn.esprit.happyOlds.Events.Gui.EventsAffiche;
import tn.esprit.happyOlds.Medical.Gui.Medical;
import tn.esprit.happyOlds.Services.Gui.Services;


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
            Medical medical = new Medical();
            medical.getForm().show();
        });
        f.getToolbar().addCommandToSideMenu("Evénements", null, (e)->{
            EventsAffiche s = new EventsAffiche();
            s.getF().show();
        });
        f.getToolbar().addCommandToSideMenu("Divertissement", null, (e)->{
            DivertissementGui divertissement = new DivertissementGui(f);
             divertissement.getForm().show();
        });
        f.getToolbar().addCommandToSideMenu("Se déconnecter", null, (e)->{
            login l = new login();
            
            l.getF().show();
        });
    }
    
}
