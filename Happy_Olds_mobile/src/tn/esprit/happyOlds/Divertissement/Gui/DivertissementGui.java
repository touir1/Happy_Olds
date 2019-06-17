/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.Gui;

import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.Border;
import com.codename1.ui.util.Resources;
import java.util.List;
import tn.esprit.happyOlds.Divertissement.controller.DivertissementController;
import tn.esprit.happyOlds.Divertissement.controller.Utils;
import tn.esprit.happyOlds.Divertissement.entity.Publication;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.MyApplication;

/**
 *
 * @author touir
 */
public class DivertissementGui extends CustomGui{
    
    private static int index, pageSize;
    
    public DivertissementGui(Form caller) {
        super("Divertissement",caller);
        
        BoxLayout boxLayout = new BoxLayout(BoxLayout.Y_AXIS);
        form.setLayout(boxLayout);
        
        form.getToolbar().addCommandToOverflowMenu("créer groupe",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("rechercher groupe",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("mes inscriptions aux groupes",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("Conversations",null,(err)->{
            
        });
        
        Container publicationsContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container buttonContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        
        form.add(publicationsContainer);
        form.add(buttonContainer);
        
        index = 1;
        pageSize = 10;
        
        // get list of publications
        List<Publication> listPublication = DivertissementController.getPublications(index, pageSize);
        for (Publication pub : listPublication) {
            publicationsContainer.add(addItem(pub));
        }
        index++;
        
        Button getMoreButton = Utils.getHyperlinkButton("Afficher plus ...");
        getMoreButton.addActionListener(e -> {
            List<Publication> more = DivertissementController.getPublications(index, pageSize);
            for (Publication pub : more) {
                publicationsContainer.add(addItem(pub));
            }
            index++;
        });
        
        buttonContainer.add(getMoreButton);
    }
    
    private Container addItem(Publication publication) {
        Container cnt1 = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container cnt3 = new Container(new BoxLayout(BoxLayout.X_AXIS));
        Label lblusername = new Label(publication.getUser().getFullName());
        Label separator = new Label(">");
        Button btngroup = Utils.getHyperlinkButton(publication.getGroupe().getTitre());
        //lblusername.setSize(new Dimension(20, 20));
        Label lbDE = new Label(publication.getDescription());
        //lbDE.setSize(new Dimension(20, 20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt3.add(btngroup);
        cnt3.add(separator);
        cnt3.add(lblusername);
        cnt2.add(lbDE);
        cnt1.add(cnt3);
        cnt1.add(cnt2);
        btngroup.addActionListener(e -> {
            GroupeGui groupeGui = new GroupeGui(form,publication.getGroupe().getId());
            groupeGui.getForm().show();
        });
        lbDE.addPointerPressedListener((e)->{
            
        });

        return cnt1;
    }
}
