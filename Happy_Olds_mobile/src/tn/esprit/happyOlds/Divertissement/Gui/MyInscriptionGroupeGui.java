/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.Gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.InfiniteProgress;
import com.codename1.components.SpanLabel;
import com.codename1.ui.BrowserComponent;
import com.codename1.ui.Button;
import com.codename1.ui.Component;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.Font;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.URLImage;
import com.codename1.ui.geom.Dimension;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;
import java.util.List;
import tn.esprit.happyOlds.Divertissement.controller.DivertissementController;
import tn.esprit.happyOlds.Divertissement.controller.GroupeController;
import tn.esprit.happyOlds.Divertissement.controller.PublicationController;
import tn.esprit.happyOlds.Divertissement.controller.Utils;
import tn.esprit.happyOlds.Divertissement.entity.Groupe;
import tn.esprit.happyOlds.Divertissement.entity.Publication;

/**
 *
 * @author touir
 */
public class MyInscriptionGroupeGui extends CustomGui{
    
    private static int index, pageSize;
    
    private List<Groupe> groupes;
    private Container groupesContainer;
    private String filter;
    
    public MyInscriptionGroupeGui(Form caller){
        super("Liste des inscriptions",caller,true);
        
        this.filter = "";
        
        groupesContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        
        form.getToolbar().addCommandToOverflowMenu("File d'actualités",null,(err)->{
            DivertissementGui divertissementGui = new DivertissementGui(form);
            divertissementGui.getForm().show();
        });
        form.getToolbar().addCommandToOverflowMenu("Mes groupes",null,(err)->{
            MyGroupeGui myGroupeGui = new MyGroupeGui(form);
            myGroupeGui.getForm().show();
        });
        
        Container searchContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container buttonContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        
        form.add(searchContainer);
        form.add(groupesContainer);
        form.add(buttonContainer);
        
        searchContainer.add(addFilterItem());
        
        Button getMoreButton = Utils.getHyperlinkButton("Afficher plus ...");
        getMoreButton.addActionListener(e -> {
            System.out.println("show more");
            // loading
            Dialog ip2 = new InfiniteProgress().showInfiniteBlocking();
            List<Groupe> more = GroupeController.getMyInscriptionGroupes(index, pageSize, "");
            for (Groupe groupe : more) {
                groupesContainer.add(addItem(groupe));
            }
            index++;
            if(pageSize > more.size()){
                getMoreButton.setVisible(false);
            }
            // end loading
            ip2.dispose();
        });
        buttonContainer.add(getMoreButton);
        
        form.show();
        
        refreshView();
        
    }
    
    private void refreshView(){
        groupesContainer.removeAll();
        
        BoxLayout boxLayout = new BoxLayout(BoxLayout.Y_AXIS);
        groupesContainer.setLayout(boxLayout);
        
        index = 1;
        pageSize = 10;
        
        new Thread(() -> {
            // start loading
            Dialog ip = new InfiniteProgress().showInfiniteBlocking();
            groupes = GroupeController.getMyInscriptionGroupes(index, pageSize, filter);
            
            for (Groupe groupe : groupes) {
                groupesContainer.add(addItem(groupe));
            }
            index++;
            
            
            // stop loading
            ip.dispose();
        }).start();
    }
    
    private Container addItem(Groupe groupe) {
        Font mediumItalicSystemFont = Font.createSystemFont(Font.FACE_SYSTEM, Font.STYLE_ITALIC, Font.SIZE_LARGE);
        
        Container cnt1 = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container cnt3 = new Container(new BoxLayout(BoxLayout.X_AXIS));
        Label lblGroupe = new Label(groupe.getTitre());
        lblGroupe.getUnselectedStyle().setFont(mediumItalicSystemFont);
        //lblusername.setSize(new Dimension(20, 20));
        SpanLabel lbDE = new SpanLabel(groupe.getSujet().getLabel());

        //lbDE.setSize(new Dimension(20, 20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt3.add(lblGroupe);
        cnt2.add(lbDE);
        
        ImageViewer /*separatorTop = new ImageViewer(theme.getImage("separator_top.png")),
                separatorBottom = new ImageViewer(theme.getImage("separator_bottom.png")),*/
                separatorMiddle = new ImageViewer(theme.getImage("separator.png"));
        //cnt1.add(separatorTop);
        cnt1.add(separatorMiddle);
        cnt1.add(cnt3);
        //cnt1.add(separatorMiddle);
        cnt1.add(cnt2);
        //cnt1.add(separatorBottom);
        
        Button clickEventButton = new Button();
        clickEventButton.addActionListener(e -> {
            GroupeGui groupeGui = new GroupeGui(form,groupe.getId(),groupe.getTitre());
            groupeGui.getForm().show();
        });
        cnt1.setLeadComponent(clickEventButton);


        return cnt1;
    }
    
    
    private Container addFilterItem(){
        Container container = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        
        TextField textFilter = new TextField("","Nom groupe", 80, TextArea.ANY);
        //textPublication.setSingleLineTextArea(false);
        Button searchButton = new Button("Rechercher");
        searchButton.addActionListener(e -> {
            this.filter = textFilter.getText();
            refreshView();
        });
        FlowLayout fwl = new FlowLayout(Component.RIGHT);
        Container filterContainer = new Container(fwl);
        filterContainer.addAll(textFilter,searchButton);
        
        container.add(filterContainer);
        
        return container;
    }
    
}
