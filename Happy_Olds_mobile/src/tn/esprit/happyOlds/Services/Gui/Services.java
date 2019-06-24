/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Services.Gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.SpanLabel;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.Log;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextArea;
import com.codename1.ui.Toolbar;
import com.codename1.ui.URLImage;
import com.codename1.ui.geom.Dimension;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.UIManager;
import com.codename1.ui.util.Resources;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.MyApplication;
import tn.esprit.happyOlds.Services.controller.ServicesController;
import tn.esprit.happyOlds.Services.entity.Service;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author SadfiAmine
 */
public class Services {
    Form f,F1;
    private Resources theme;
      public void init(Object context) {
        //theme = UIManager.initFirstTheme("C:\\wamp64\\www\\Happy_Olds\\Happy_Olds_mobile\\src");

        // Enable Toolbar on all Forms by default
        Toolbar.setGlobalToolbar(true);

        // Pro only feature
        Log.bindCrashProtection(true);
    }
    public Services(){
        List<Service> lstServices=new ArrayList<>();
        
         f = new Form("Services");
         //menu 
         menu m=new menu();
         m.addmenu(f);
         ServicesController sc = new ServicesController();
        lstServices= sc.getServices();
        for(int i=0;i<lstServices.size();i++){
            try {
                f.add(addItem(lstServices.get(i)));
                System.out.println("Path "+ lstServices.get(i).getUser().getPath());
            } catch (IOException ex) {
              ex.getMessage();
            }
        }
          if (UserController.userConnectee.getRole().equals("ROLE_AGE")){
                 f.getToolbar().addCommandToOverflowMenu("demander un service",null,(err)->{
                  
                        
                         AddService a=new AddService();
                         a.getF1().show();
                    
           
           });
             }
    }
 public Container addItem(Service s) throws IOException {
        
        Container cnt1 = new Container(new BorderLayout());
        Label lblusername = new Label(s.getUser().getUsername());
        lblusername.setSize(new Dimension(20, 20));
        Label lbDE = new Label(s.getDescription());
        lblusername.setSize(new Dimension(20, 20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt2.add(lblusername);
        cnt2.add(lbDE);
        MyApplication my= new MyApplication();
         Label lblimg = new Label();
        if(s.getUser().getPath()!=null){
           Image red = Image.createImage(50, 50);  

            EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + s.getId(), "http://127.0.0.1:8000/uploads/documents/"+s.getUser().getPath()); 
            //Image red = Image.createImage("file:///C:/wamp64/www/Happy_Olds/Happy_Olds_Web/web/uploads/documents/"+s.getUser().getPath());  
            
             ImageViewer img = new ImageViewer(urlIm);
         
            cnt1.add(BorderLayout.WEST, img); }
        else{    
            Image red = Image.createImage("http://127.0.0.1:8000/dist/img/default-avatar.png");
            ImageViewer img = new ImageViewer(red);
             lblimg.setIcon(red);
            cnt1.add(BorderLayout.WEST, img);
                

        }
        
        cnt1.add(BorderLayout.CENTER, cnt2);
        lbDE.addPointerPressedListener((e)->{
        F1 = new Form(s.getType().toString(),BoxLayout.y());
            /*EncodedImage enc = EncodedImage.
                    createFromImage(theme.getImage("round.png"), false);
            URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + c.getId(), c.getUrlImage());
            ImageViewer img = new ImageViewer(urlIm);
            F1.add(img);*/
            Service service= new Service();
            ServicesController sc = new ServicesController();
            service=sc.getService(s.getId());
             Label lusername = new Label(s.getUser().getUsername());
             SpanLabel lb = new SpanLabel(s.getDescription());
             Label lbtype = new Label(s.getType());
             Label lbldate = new Label(s.getDate().toString());
             F1.add(lusername);
             F1.add(lb);
             F1.add(lbtype);
             F1.add(lbldate);
             Button Postuler= new Button("Postuler");
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
                /* EncodedImage enc = EncodedImage.
                    createFromImage(theme.getImage("round.png"), false);
            URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + s.getId(),"http://127.0.0.1:8000/uploads/documents/avatarH.jpg");
            ImageViewer img = new ImageViewer(urlIm);*/
                SpanLabel cUsername = new SpanLabel(s.getCommenatires().get(i).getUser().getUsername());
                
                 SpanLabel ctexte = new SpanLabel(s.getCommenatires().get(i).getTexte());
                 F1.add(cUsername);
                 F1.add(ctexte);
             }
             
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
