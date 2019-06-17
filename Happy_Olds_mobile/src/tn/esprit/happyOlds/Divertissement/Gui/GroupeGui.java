/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.Gui;

import com.codename1.ui.Form;
import tn.esprit.happyOlds.Divertissement.controller.GroupeController;
import tn.esprit.happyOlds.Divertissement.entity.Groupe;

/**
 *
 * @author touir
 */
public class GroupeGui extends CustomGui{
    
    private int groupeId;
    private Groupe groupe;

    public int getGroupeId() {
        return groupeId;
    }

    public void setGroupeId(int groupeId) {
        this.groupeId = groupeId;
    }
    
    public GroupeGui(Form caller, int groupId){
        super("Groupe",caller);
        this.groupeId = groupId;
        
        groupe = GroupeController.findGroupe(groupeId);
        
    }
}
