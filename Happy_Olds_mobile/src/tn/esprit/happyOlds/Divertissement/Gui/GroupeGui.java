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
import static tn.esprit.happyOlds.Divertissement.Gui.DivertissementGui.getChangeMediaScript;
import tn.esprit.happyOlds.Divertissement.controller.DivertissementController;
import tn.esprit.happyOlds.Divertissement.controller.GroupeController;
import tn.esprit.happyOlds.Divertissement.controller.PublicationController;
import tn.esprit.happyOlds.Divertissement.controller.Utils;
import tn.esprit.happyOlds.Divertissement.entity.Groupe;
import tn.esprit.happyOlds.Divertissement.entity.Publication;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author touir
 */
public class GroupeGui extends CustomGui{
    
    private int groupeId;
    private Groupe groupe;
    
    private static int index, pageSize;
    
    public static String getChangeMediaScript(String mediaUrl,String mimeType)
    {
        return "document.getElementById('src_id').src=\"" + mediaUrl + "\";\n"
                + "document.getElementById('src_id').type=\""+mimeType+"\";\n"
                + "document.getElementById('media_id').load();\n";
    }
    
    private static List<BrowserComponent> browsers;

    public int getGroupeId() {
        return groupeId;
    }

    public void setGroupeId(int groupeId) {
        this.groupeId = groupeId;
    }
    
    public GroupeGui(Form caller, int groupId, String nomGroupe){
        super("Groupe - "+nomGroupe,caller,false);
        this.groupeId = groupId;
        
        BoxLayout boxLayout = new BoxLayout(BoxLayout.Y_AXIS);
        form.setLayout(boxLayout);
        
        browsers = new ArrayList<>();
        
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
        
        refreshView();
        
        
    }
    
    private void refreshView(){
        form.removeAll();
        
        browsers = new ArrayList<>();
        
        Container groupeContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container publicationsContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container buttonContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        
        form.add(groupeContainer);
        form.add(publicationsContainer);
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
            
            groupe = GroupeController.findGroupe(groupeId);
            
            groupeContainer.add(addGroupItem(groupe));
            
            // get list of publications
            List<Publication> listPublication = DivertissementController.getPublications(index, pageSize, groupeId);
            for (Publication pub : listPublication) {
                publicationsContainer.add(addItem(pub));
            }
            index++;
            
            Button getMoreButton = Utils.getHyperlinkButton("Afficher plus ...");
            getMoreButton.addActionListener(e -> {
                System.out.println("show more");
                // loading
                Dialog ip2 = new InfiniteProgress().showInfiniteBlocking();
                List<Publication> more = DivertissementController.getPublications(index, pageSize, groupeId);
                for (Publication pub : more) {
                    publicationsContainer.add(addItem(pub));
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
    
    private Container addGroupItem(Groupe groupe){
        Container container = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        
        Label description = new Label("Description: "+groupe.getDescription());
        Label type = new Label("Type: "+groupe.getType());
        Label sujet = new Label("Sujet: "+groupe.getSujet().getLabel());
        Label creator = new Label("Créateur: "+groupe.getCreator().getFullName());
        
        container.addAll(description,type,sujet,creator);
        ImageViewer separator = new ImageViewer(theme.getImage("separator.png"));
        container.add(separator);
        
        TextField textPublication = new TextField("","Description", 80, TextArea.ANY);
        textPublication.setSingleLineTextArea(false);
        Button sendPublication = new Button("Publier");
        sendPublication.addActionListener(e -> {
            Publication publication = new Publication();
            Groupe groupe2 = new Groupe();
            groupe2.setId(groupeId);
            publication.setGroupe(groupe2);
            publication.setDatePublication(new Date());
            publication.setDescription(textPublication.getText());
            
            // start loading
            Dialog ip = new InfiniteProgress().showInfiniteBlocking();
            PublicationController.sendPublication(publication);
            textPublication.clear();
            
            ip.dispose();
            Dialog.show("Success", "Publication réussite", "OK",null);
            refreshView();
        });
        FlowLayout fwl = new FlowLayout(Component.RIGHT);
        Container publierContainer = new Container(fwl);
        publierContainer.addAll(textPublication,sendPublication);
        
        container.add(publierContainer);
        
        return container;
    }
    
    private Container addItem(Publication publication) {
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
        
        ImageViewer /*separatorTop = new ImageViewer(theme.getImage("separator_top.png")),
                separatorBottom = new ImageViewer(theme.getImage("separator_bottom.png")),*/
                separatorMiddle = new ImageViewer(theme.getImage("separator.png"));
        //cnt1.add(separatorTop);
        cnt1.add(separatorMiddle);
        cnt1.add(cnt3);
        //cnt1.add(separatorMiddle);
        cnt1.add(cnt2);
        //cnt1.add(separatorBottom);
        
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
                browsers.add(browser);
                /*
                try {
                    Media video = MediaManager.createMedia(Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath(), true);
                    video.setFullScreen(true);
                    MediaPlayer mediaPlayer = new MediaPlayer(video);
                    Container videoContainer = new Container(new BorderLayout());
                    videoContainer.addComponent(BorderLayout.CENTER,mediaPlayer);
                    cnt2.add(videoContainer);
                    //cnt2.add(mediaPlayer);
                } catch (IOException ex) {
                    Logger.getLogger(DivertissementGui.class.getName()).log(Level.SEVERE, null, ex);
                }
                */
                
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
                browsers.add(browser);
                /*
                try {
                    Media video = MediaManager.createMedia(Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath(), true);
                    video.setFullScreen(true);
                    MediaPlayer mediaPlayer = new MediaPlayer(video);
                    Container videoContainer = new Container(new BorderLayout());
                    videoContainer.addComponent(BorderLayout.CENTER,mediaPlayer);
                    cnt2.add(videoContainer);
                    //cnt2.add(mediaPlayer);
                } catch (IOException ex) {
                    Logger.getLogger(DivertissementGui.class.getName()).log(Level.SEVERE, null, ex);
                }
                */
            }
            else
            {
                ImageViewer imgV=new ImageViewer(theme.getImage("not_supported.png"));
                cnt2.add(imgV);
            }
        }
        
        Button clickEventButton = new Button();
        clickEventButton.addActionListener(e -> {
            PublicationGui publicationGui = new PublicationGui(form,publication.getId());
            publicationGui.getForm().show();
        });
        lbDE.setLeadComponent(clickEventButton);
        /*
        lbDE.addPointerPressedListener((e)->{
            PublicationGui publicationGui = new PublicationGui(form,publication.getId());
            publicationGui.getForm().show();
        });
        */

        return cnt1;
    }
}
