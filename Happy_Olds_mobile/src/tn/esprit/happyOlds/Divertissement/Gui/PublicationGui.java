/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.Gui;

import com.codename1.ui.Form;
import com.codename1.ui.layouts.BoxLayout;
import java.util.ArrayList;
import tn.esprit.happyOlds.Divertissement.controller.PublicationController;

/**
 *
 * @author touir
 */
public class PublicationGui extends CustomGui{
    
    private int publicationId;
    
    public PublicationGui(Form caller, int publicationId){
        super("Publication",caller,false);
        this.publicationId = publicationId;
        
        refreshView();
    }
    
    private void refreshView(){
        form.removeAll();
        
        BoxLayout boxLayout = new BoxLayout(BoxLayout.Y_AXIS);
        form.setLayout(boxLayout);
        
        /*
        form.getToolbar().addCommandToOverflowMenu("créer groupe",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("rechercher groupe",null,(err)->{
            
        });
        */
        form.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
              caller.showBack();
        });
        
        form.getToolbar().addCommandToOverflowMenu("File d'actualités",null,(err)->{
            DivertissementGui divertissementGui = new DivertissementGui(form);
            divertissementGui.getForm().show();
        });
        form.getToolbar().addCommandToOverflowMenu("Mes inscriptions aux groupes",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("Mes groupes",null,(err)->{
            MyGroupeGui myGroupeGui = new MyGroupeGui(form);
            myGroupeGui.getForm().show();
        });
    }
    
}
