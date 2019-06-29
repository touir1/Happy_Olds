/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Events.Gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.SpanLabel;
import com.codename1.ui.Container;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.URLImage;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.MyApplication;
import tn.esprit.happyOlds.controller.UserController;
import tn.esprit.happyOlds.events.controller.EventsController;
import tn.esprit.happyOlds.events.entities.Events;

/**
 *
 * @author SadfiAmine
 */
public class EventsAffiche {
    Form f,F1;
   
    public EventsAffiche(){
        List<Events> lstEvents=new ArrayList<>();
        
         f = new Form("Events");
         //menu 
         menu m=new menu();
         m.addmenu(f);
         EventsController ec = new EventsController();
        lstEvents= ec.getEvents();
        for(int i=0;i<lstEvents.size();i++){
            try {
                f.add(addItem(lstEvents.get(i)));
                
            } catch (IOException ex) {
              ex.getMessage();
            }
        }
          if (UserController.userConnectee.getRole().equals("ROLE_AGE")){
                f.getToolbar().addCommandToOverflowMenu("demander un service",null,(err)->{
                  
                        
                         AddEvents a=new AddEvents();
                         a.getF1().show();
                    
           
           });
             }
    }
 public Container addItem(Events e) throws IOException {
        
        Container cnt1 = new Container(new BorderLayout());
        Label lbltitle = new Label(e.getId_user().getUsername());
       
        Label lbnbparticipant = new Label(e.getParticipant()+"/"+e.getNbrParticipant());
        
        Container cnt2 = new Container(BoxLayout.y());
        cnt2.add(lbltitle);
        cnt2.add(lbnbparticipant);
      
         Label lblimg = new Label();
         Image red = Image.createImage(50, 50);  
         
        if(e.getPath()!=null){
           

            EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + e.getId(), "http://127.0.0.1:8000/uploads/documents/"+e.getPath(),URLImage.RESIZE_SCALE_TO_FILL); 
            
             ImageViewer img = new ImageViewer(urlIm);
         
            cnt1.add(BorderLayout.WEST, img); }
        else{    
             EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                     createToStorage(enc, "Img" + e.getId(),"http://127.0.0.1:8000/dist/img/default-avatar.png",URLImage.RESIZE_SCALE_TO_FILL);
            ImageViewer img = new ImageViewer(urlIm);
            
            cnt1.add(BorderLayout.WEST, img);
                

        }
        
        cnt1.add(BorderLayout.CENTER, cnt2);
        lbnbparticipant.addPointerPressedListener((r)->{
        F1 = new Form(e.getTitre(),BoxLayout.y());
             if(e.getPath()!=null){
                    EncodedImage enc = EncodedImage.
                       createFromImage(MyApplication.getTheme().getImage("round.png"), false);
                    
                URLImage urlIm = URLImage.
                       createToStorage(enc, "Img" + e.getId(), "http://127.0.0.1:8000/uploads/documents/"+e.getPath(),URLImage.RESIZE_SCALE); 

                ImageViewer img = new ImageViewer(urlIm);
         
            F1.add(img); }
              else{
                     EncodedImage enc = EncodedImage.
                       createFromImage(MyApplication.getTheme().getImage("round.png"), false);
              URLImage urlIm = URLImage.
                      createToStorage(enc, "Img" + e.getId(),"http://127.0.0.1:8000/dist/img/default-avatar.png",URLImage.RESIZE_SCALE);
             ImageViewer img = new ImageViewer(urlIm);
            
            F1.add(img);
              }
        /*    Service service= new Service();
            ServicesController sc = new ServicesController();
            service=sc.getService(s.getId());*/
          
             SpanLabel lb = new SpanLabel("Description: "+e.getDescription());
             SpanLabel lb1 = new SpanLabel("ville: "+e.getVille());
             Label lbtype = new Label("lieu: "+e.getPrivilege());
             F1.add(lb);
             F1.add(lb1);
             F1.add(lbtype);
            /* Button Postuler= new Button("Postuler");
             Postuler.addActionListener(l->{
                int trouve=0,i=0;
                while(i<s.getPostuler().size()&& trouve==0){
                    if(s.getPostuler().get(i).getUser().getId()==UserController.userConnectee.getId()){
                        trouve=1;
                        i++;
                    }
                    i++;
                }
                if(trouve==0){
                    String rep=sc.PostulerService(UserController.userConnectee.getId(), s.getId());
                    if(!rep.isEmpty()){
                         Dialog.show("Message", "félicitation! Votre candidature a bien été enregistrée  ", "OK", null);
                         Services services= new Services();
                          services.getF().show();
                    }
                }
                else{
                    Dialog.show("Message", UserController.userConnectee.getUsername()+" Vous avez déja postuler à ce service ", "OK", null);
                   
                }
             });
             if(UserController.userConnectee.getRole().equals("ROLE_JEUNE")){
             F1.add(Postuler);
             }
             Label lblcom = new Label("Commentaires :");
             F1.add(lblcom);
           
             for(int i=0;i<s.getCommenatires().size();i++){
                   Container Cimg= new Container(new BorderLayout());
              Container Ccom = new Container(BoxLayout.y());
              if(s.getCommenatires().get(i).getUser().getPath()!=null){
                    EncodedImage enc = EncodedImage.
                       createFromImage(MyApplication.getTheme().getImage("round.png"), false);
                    
                URLImage urlIm = URLImage.
                       createToStorage(enc, "Img" + s.getId(), "http://127.0.0.1:8000/uploads/documents/"+s.getCommenatires().get(i).getUser().getPath(),URLImage.RESIZE_SCALE); 

                ImageViewer img = new ImageViewer(urlIm);
         
            Cimg.add(BorderLayout.WEST, img); }
              else{
                     EncodedImage enc = EncodedImage.
                       createFromImage(MyApplication.getTheme().getImage("round.png"), false);
              URLImage urlIm = URLImage.
                      createToStorage(enc, "Img" + s.getId(),"http://127.0.0.1:8000/dist/img/default-avatar.png",URLImage.RESIZE_SCALE);
             ImageViewer img = new ImageViewer(urlIm);
            
            Cimg.add(BorderLayout.WEST, img);
              }
                /* EncodedImage enc = EncodedImage.
                    createFromImage(theme.getImage("round.png"), false);
            URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + s.getId(),"http://127.0.0.1:8000/uploads/documents/avatarH.jpg");
            ImageViewer img = new ImageViewer(urlIm);*/
             /*   SpanLabel cUsername = new SpanLabel(s.getCommenatires().get(i).getUser().getUsername());
                
                 SpanLabel ctexte = new SpanLabel(s.getCommenatires().get(i).getTexte());
                 Ccom.add(cUsername);
                 Ccom.add(ctexte);
                 Cimg.add(BorderLayout.CENTER, Ccom);
                 F1.add(Cimg); 
                 
             }*/
             
             F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
                f.show();
          
            });
             
           
             
             F1.show();
             
            
            

        });

        return cnt1;
    }
    public Form getF() {
        return f;
    }

    public void setF(Form f) {
        this.f = f;
    }
    
}
