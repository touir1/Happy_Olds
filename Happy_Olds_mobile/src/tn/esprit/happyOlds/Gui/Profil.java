/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.SpanLabel;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.Container;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.URLImage;
import com.codename1.ui.geom.Dimension;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import java.io.IOException;
import tn.esprit.happyOlds.Medical.entity.Question;
import tn.esprit.happyOlds.MyApplication;
import tn.esprit.happyOlds.controller.UserController;
import tn.esprit.happyOlds.entity.User;

/**
 *
 * @author SadfiAmine
 */
public class Profil {
     Form f;

    public Profil() {
        f = new Form("Profil");
      
        //menu 
        menu m=new menu();
        m.addmenu(f);
         Container cnt1 = new Container(new BorderLayout());
         Label lusername = new Label ("Username : ");
         Label lscore = new Label ("Score final : ");
         Label lville = new Label ("Ville : ");
         Label ldatenaiss = new Label ("Date de naissance : ");
         Label ljob = new Label ("Job : ");
         Label lnom = new Label ("Nom : ");
         Label lprenom = new Label ("Prenom : ");
         Label lrole = new Label ("Role : ");
         SimpleDateFormat dt1 = new SimpleDateFormat("dd/MM/yyyy");
         
        Label lblusername = new Label(UserController.userConnectee.getUsername());
        Integer var = UserController.userConnectee.getScorefinal();
        String test = var.toString();
        Label scoref = new Label(test);
        Label lbrole= new Label(UserController.userConnectee.getRole());
        Label lbnom = new Label(UserController.userConnectee.getNom());
        Label lbprenom = new Label(UserController.userConnectee.getPrenom());
        Label lbville = new Label(UserController.userConnectee.getVille());
        Label lbjob = new Label(UserController.userConnectee.getJob());
        Label lbdatenaissance = new Label(dt1.format(UserController.userConnectee.getDate_naissance()));
        
        lblusername.setSize(new Dimension(20, 20));
        lbrole.setSize(new Dimension (20,20));
         lbnom.setSize(new Dimension (20,20));
          lbprenom.setSize(new Dimension (20,20));
           lbville.setSize(new Dimension (20,20));
            lbjob.setSize(new Dimension (20,20));
        Container cnt2 = new Container(BoxLayout.y());
        Container cnt3 = new Container(BoxLayout.y());
        cnt2.add(lblusername);
        cnt2.add(scoref);
        cnt2.add(lbdatenaissance);
        cnt2.add(lbrole);
        cnt2.add(lbnom);
        cnt2.add(lbprenom);
        cnt2.add(lbville);
        cnt2.add(lbjob);
        cnt3.add(lusername);
        cnt3.add(lscore);
        cnt3.add(ldatenaiss);
        cnt3.add(lrole);
        cnt3.add(lnom);
        cnt3.add(lprenom);
        cnt3.add(lville);
        cnt3.add(ljob);
        MyApplication my= new MyApplication();
         Label lblimg = new Label();
    Image red = Image.createImage(50, 50);  
        if(UserController.userConnectee.getPath()!=null){
           

            EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + UserController.userConnectee.getId(), "http://127.0.0.1:8000/uploads/documents/"+UserController.userConnectee.getPath()); 
            //Image red = Image.createImage("file:///C:/wamp64/www/Happy_Olds/Happy_Olds_Web/web/uploads/documents/"+s.getUser().getPath());  
            
             ImageViewer img = new ImageViewer(urlIm);
         
            cnt1.add(BorderLayout.NORTH, img); }
        else{    
             EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                     createToStorage(enc, "Img" + UserController.userConnectee.getId(),"http://127.0.0.1:8000/dist/img/default-avatar.png");
            ImageViewer img = new ImageViewer(urlIm);
            
            cnt1.add(BorderLayout.NORTH, img);
                

        }
        cnt1.add(BorderLayout.EAST, cnt2);
        cnt1.add(BorderLayout.WEST, cnt3);
        f.add(cnt1);
       
    }

  
    
    
    public Form getF() {
        return f;
    }

    public void setF(Form f) {
        this.f = f;
    }
     
}
