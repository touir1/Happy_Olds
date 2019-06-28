/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.Gui;

import com.codename1.ui.Button;
import com.codename1.ui.Component;
import com.codename1.ui.Container;
import com.codename1.ui.Form;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import tn.esprit.happyOlds.Divertissement.controller.CustomController;
import tn.esprit.happyOlds.Divertissement.controller.DivertissementController;
import tn.esprit.happyOlds.Divertissement.controller.Utils;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.MyApplication;

/**
 *
 * @author touir
 */
public class CustomGui {
    protected Form form;
    protected Resources theme;
    protected Form caller;

    public Form getForm() {
        return form;
    }

    public Form getCaller() {
        return caller;
    }
    
    public CustomGui(String formTitle, Form caller, boolean withMenu){
        this.form = new Form(formTitle);
        
        if(withMenu) new menu().addmenu(this.form);
        
        this.theme = MyApplication.getTheme();
        
        this.caller = caller;
        
        /*
        if(caller != null){
            Button back = Utils.getHyperlinkButton("Back");
            back.addActionListener(e -> {
                caller.showBack();
            });
            Container container = new Container(new BoxLayout(BoxLayout.X_AXIS));
            container.add(back);
            form.add(container);
        }
        */
    }
}
