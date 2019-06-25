/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Divertissement.Gui;

import com.codename1.components.ImageViewer;
import com.codename1.ui.BrowserComponent;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.URLImage;
import com.codename1.ui.geom.Dimension;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import static tn.esprit.happyOlds.Divertissement.Gui.DivertissementGui.getChangeMediaScript;
import tn.esprit.happyOlds.Divertissement.controller.DivertissementController;
import tn.esprit.happyOlds.Divertissement.controller.GroupeController;
import tn.esprit.happyOlds.Divertissement.controller.Utils;
import tn.esprit.happyOlds.Divertissement.entity.Groupe;
import tn.esprit.happyOlds.Divertissement.entity.Publication;

/**
 *
 * @author touir
 */
public class GroupeGui extends CustomGui{
    
    private int groupeId;
    private Groupe groupe;
    
    private static int index, pageSize;
    
    private final String[] IMAGE_MIMES = {"image/png","image/gif","image/jpeg", "image/bmp", "image/webp"};
    private final String[] VIDEO_MIMES = {"video/mp4","video/webm","video/ogg","video/x-msvideo","video/mpeg"};
    private final String[] AUDIO_MIMES = {"audio/mpeg", "audio/ogg", "audio/wav"};
    
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
        super("Groupe - "+nomGroupe,caller);
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
        
        new Thread(() -> {
            groupe = GroupeController.findGroupe(groupeId);
            
            // get list of publications
            List<Publication> listPublication = DivertissementController.getPublications(index, pageSize, groupId);
            for (Publication pub : listPublication) {
                publicationsContainer.add(addItem(pub));
            }
            index++;
            
            Button getMoreButton = Utils.getHyperlinkButton("Afficher plus ...");
            getMoreButton.addActionListener(e -> {
                List<Publication> more = DivertissementController.getPublications(index, pageSize, groupId);
                for (Publication pub : more) {
                    publicationsContainer.add(addItem(pub));
                }
                index++;
            });
            buttonContainer.add(getMoreButton);
        }).start();
    }
    
    private Container addItem(Publication publication) {
        Container cnt1 = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Container cnt3 = new Container(new BoxLayout(BoxLayout.X_AXIS));
        Label lblusername = new Label(publication.getUser().getFullName());
        //lblusername.setSize(new Dimension(20, 20));
        Label lbDE = new Label(publication.getDescription());
        //lbDE.setSize(new Dimension(20, 20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt3.add(lblusername);
        cnt2.add(lbDE);
        cnt1.add(cnt3);
        cnt1.add(cnt2);
        
        if(publication.getPieceJointe() != null && publication.getPieceJointe().getWebPath() != null
                && !"".equals(publication.getPieceJointe().getWebPath().trim()))
        {
            if(Arrays.asList(IMAGE_MIMES).contains(publication.getPieceJointe().getMimeType())){
            
                EncodedImage enc=EncodedImage.
                    createFromImage(theme.getImage("loading.png"), false);

                Image image = URLImage.createToStorage(enc, "publication_image_"+publication.getId(), Utils.serverUrl + "/" + publication.getPieceJointe().getWebPath(), URLImage.RESIZE_SCALE); 
                ImageViewer imgV=new ImageViewer(image);
                cnt2.add(imgV);
            }
            else if(Arrays.asList(VIDEO_MIMES).contains(publication.getPieceJointe().getMimeType()))
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
            else if(Arrays.asList(AUDIO_MIMES).contains(publication.getPieceJointe().getMimeType()))
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
        
        lbDE.addPointerPressedListener((e)->{
            
        });

        return cnt1;
    }
}
