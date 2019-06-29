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
import static tn.esprit.happyOlds.Divertissement.Gui.GroupeGui.getChangeMediaScript;
import tn.esprit.happyOlds.Divertissement.controller.DivertissementController;
import tn.esprit.happyOlds.Divertissement.controller.GroupeController;
import tn.esprit.happyOlds.Divertissement.controller.PublicationController;
import tn.esprit.happyOlds.Divertissement.controller.Utils;
import tn.esprit.happyOlds.Divertissement.entity.Commentaire;
import tn.esprit.happyOlds.Divertissement.entity.Groupe;
import tn.esprit.happyOlds.Divertissement.entity.Publication;

/**
 *
 * @author touir
 */
public class PublicationGui extends CustomGui{
    
    private int publicationId;
    private Publication publication;
    
    private static int index, pageSize;
    
    public PublicationGui(Form caller, int publicationId){
        super("Publication",caller,false);
        this.publicationId = publicationId;
        
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
            MyInscriptionGroupeGui myInscriptionGui = new MyInscriptionGroupeGui(form);
            myInscriptionGui.getForm().show();
        });
        form.getToolbar().addCommandToOverflowMenu("Mes groupes",null,(err)->{
            MyGroupeGui myGroupeGui = new MyGroupeGui(form);
            myGroupeGui.getForm().show();
        });
        
        refreshView();
    }
    
    private void refreshView(){
        form.removeAll();
        
        Container publicationContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container commentsContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container buttonContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        
        form.add(publicationContainer);
        form.add(commentsContainer);
        form.add(buttonContainer);
        
        index = 1;
        pageSize = 10;
        
        /*
        new Thread(() -> {
            groupe = GroupeController.findGroupe(groupeId);
            
            groupeContainer.add(addGroupItem(groupe));
        }).start();
        */
        
        form.show();
        
        new Thread(() -> {
            // start loading
            Dialog ip = new InfiniteProgress().showInfiniteBlocking();
            
            publication = PublicationController.findPublication(publicationId);
            
            publicationContainer.add(addPublicationItem(publication));
            
            // get list of publications
            List<Commentaire> listCommentaire = PublicationController.getComments(index, pageSize, publicationId);
            for (Commentaire comment : listCommentaire) {
                commentsContainer.add(addItem(comment));
            }
            index++;
            
            Button getMoreButton = Utils.getHyperlinkButton("Afficher plus ...");
            getMoreButton.addActionListener(e -> {
                System.out.println("show more");
                // loading
                Dialog ip2 = new InfiniteProgress().showInfiniteBlocking();
                List<Commentaire> more = PublicationController.getComments(index, pageSize, publicationId);
                for (Commentaire comment : more) {
                    commentsContainer.add(addItem(comment));
                }
                index++;
                if(pageSize > more.size()){
                    getMoreButton.setVisible(false);
                }
                // end loading
                ip2.dispose();
            });
            buttonContainer.add(getMoreButton);
            
            // stop loading
            ip.dispose();
        }).start();
    }
    
    private Container addPublicationItem(Publication publication){
        Font mediumItalicSystemFont = Font.createSystemFont(Font.FACE_SYSTEM, Font.STYLE_ITALIC, Font.SIZE_LARGE);
        
        Container cnt1 = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container cnt3 = new Container(new BoxLayout(BoxLayout.X_AXIS));
        Label lblusername = new Label(publication.getUser().getFullName());
        lblusername.getUnselectedStyle().setFont(mediumItalicSystemFont);
        //lblusername.setSize(new Dimension(20, 20));
        SpanLabel lbDE = new SpanLabel(publication.getDescription());

        //lbDE.setSize(new Dimension(20, 20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt3.add(lblusername);
        cnt2.add(lbDE);
        
        cnt1.add(cnt3);
        cnt1.add(cnt2);
        
        if(publication.getPieceJointe() != null && publication.getPieceJointe().getWebPath() != null
                && !"".equals(publication.getPieceJointe().getWebPath().trim()))
        {
            if(Arrays.asList(Utils.Mimes.IMAGE_MIMES).contains(publication.getPieceJointe().getMimeType())){
            
                EncodedImage enc=EncodedImage.
                    createFromImage(theme.getImage("loading.png"), false);

                Image image = URLImage.createToStorage(enc, "publication_image_"+publication.getId(), Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath(), URLImage.RESIZE_SCALE); 
                ImageViewer imgV=new ImageViewer(image);
                cnt2.add(imgV);
            }
            else if(Arrays.asList(Utils.Mimes.VIDEO_MIMES).contains(publication.getPieceJointe().getMimeType()))
            {
                //ImageViewer imgV=new ImageViewer(theme.getImage("not_supported.png"));
                //cnt2.add(imgV);
                
                BrowserComponent browser = new BrowserComponent(){
                    @Override
                    protected Dimension calcPreferredSize() {
                        Dimension d = super.calcPreferredSize(); 
                        d.setWidth(300);
                        d.setHeight(200);
                        return d;
                    }
                };
                browser.setURL(Utils.serverUrl+"/video_player.html");
                browser.setScrollableX(false);
                browser.setScrollableY(false);
                browser.setScrollVisible(false);

                //browser.setURL(Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath());
                String script = getChangeMediaScript(
                        Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath()
                        , publication.getPieceJointe().getMimeType());
                //browser.execute(script);
                
                browser.addWebEventListener("onLoad", e -> {
                    browser.execute(script);
                });
                
                Container videoContainer = new Container(new BorderLayout()){
                    @Override
                    protected Dimension calcPreferredSize() {
                        Dimension d = super.calcPreferredSize(); 
                        d.setWidth(300);
                        d.setHeight(200);
                        return d;
                    }
                };
                videoContainer.addComponent(BorderLayout.CENTER,browser);
                cnt2.add(videoContainer);
                        
            }
            else if(Arrays.asList(Utils.Mimes.AUDIO_MIMES).contains(publication.getPieceJointe().getMimeType()))
            {
                BrowserComponent browser = new BrowserComponent(){
                    @Override
                    protected Dimension calcPreferredSize() {
                        Dimension d = super.calcPreferredSize(); 
                        d.setWidth(300);
                        d.setHeight(100);
                        return d;
                    }
                };
                browser.setURL(Utils.serverUrl+"/audio_player.html");
                browser.setScrollableX(false);
                browser.setScrollableY(false);
                browser.setScrollVisible(false);
                
                //browser.setURL(Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath());
                String script = getChangeMediaScript(
                        Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath()
                        , publication.getPieceJointe().getMimeType());
                //browser.execute(script);
                
                browser.addWebEventListener("onLoad", e -> {
                    browser.execute(script);
                });
                
                Container videoContainer = new Container(new BorderLayout()){
                    @Override
                    protected Dimension calcPreferredSize() {
                        Dimension d = super.calcPreferredSize(); 
                        d.setWidth(300);
                        d.setHeight(100);
                        return d;
                    }
                };
                videoContainer.addComponent(BorderLayout.CENTER,browser);
                cnt2.add(videoContainer);
                
            }
            else
            {
                ImageViewer imgV=new ImageViewer(theme.getImage("not_supported.png"));
                cnt2.add(imgV);
            }
        }
        
        ImageViewer separator = new ImageViewer(theme.getImage("separator.png"));
        cnt1.add(separator);
        
        TextField textComment = new TextField("","Commentaire", 80, TextArea.ANY);
        textComment.setSingleLineTextArea(false);
        Button sendPublication = new Button("Commenter");
        sendPublication.addActionListener(e -> {
            Commentaire commentaire = new Commentaire();
            Publication publication2 = new Publication();
            publication2.setId(publicationId);
            commentaire.setPublication(publication2);
            commentaire.setDateCommentaire(new Date());
            commentaire.setTexte(textComment.getText());
            
            // start loading
            Dialog ip = new InfiniteProgress().showInfiniteBlocking();
            
            PublicationController.sendCommentaire(commentaire);
            textComment.clear();
            
            ip.dispose();
            Dialog.show("Success", "Commentaire ajouté", "OK",null);
            
            refreshView();
        });
        FlowLayout fwl = new FlowLayout(Component.RIGHT);
        Container commenterContainer = new Container(fwl);
        commenterContainer.addAll(textComment,sendPublication);
        
        cnt1.add(commenterContainer);
        
        return cnt1;
    }
    
    private Container addItem(Commentaire comment) {
        Font mediumItalicSystemFont = Font.createSystemFont(Font.FACE_SYSTEM, Font.STYLE_ITALIC, Font.SIZE_LARGE);
        
        ImageViewer separator = new ImageViewer(theme.getImage("separator.png"));
        
        Container cnt1 = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container cnt3 = new Container(new BoxLayout(BoxLayout.X_AXIS));
        Label lblusername = new Label(comment.getUser().getFullName());
        lblusername.getUnselectedStyle().setFont(mediumItalicSystemFont);
        //lblusername.setSize(new Dimension(20, 20));
        SpanLabel lbDE = new SpanLabel(comment.getTexte());

        //lbDE.setSize(new Dimension(20, 20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt3.add(lblusername);
        cnt2.add(lbDE);
        
        cnt1.add(separator);
        cnt1.add(cnt3);
        cnt1.add(cnt2);

        return cnt1;
    }
    
}
