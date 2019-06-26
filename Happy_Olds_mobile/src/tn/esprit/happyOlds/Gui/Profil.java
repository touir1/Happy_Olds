/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.SpanLabel;
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
       
    }

    public Container addItem(User u) throws IOException {
        
        Container cnt1 = new Container(new BorderLayout());
        Label lblusername = new Label(u.getUsername());
        TextField scoref = new TextField(u.getScorefinal());
        Label lbrole= new Label(u.getRole());
        Label lbnom = new Label(u.getNom());
        Label lbprenom = new Label(u.getPrenom());
        Label lbville = new Label(u.getVille());
        Label lbjob = new Label(u.getJob());
        
        lblusername.setSize(new Dimension(20, 20));
        lbrole.setSize(new Dimension (20,20));
         lbnom.setSize(new Dimension (20,20));
          lbprenom.setSize(new Dimension (20,20));
           lbville.setSize(new Dimension (20,20));
            lbjob.setSize(new Dimension (20,20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt2.add(lblusername);
        cnt2.add(scoref);
        cnt2.add(lbrole);
        cnt2.add(lbnom);
        cnt2.add(lbprenom);
        cnt2.add(lbville);
        cnt2.add(lbjob);
        
        MyApplication my= new MyApplication();
         Label lblimg = new Label();
    Image red = Image.createImage(50, 50);  
        if(u.getPath()!=null){
           

            EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + u.getId(), "http://127.0.0.1:8000/uploads/documents/"+u.getPath()); 
            //Image red = Image.createImage("file:///C:/wamp64/www/Happy_Olds/Happy_Olds_Web/web/uploads/documents/"+s.getUser().getPath());  
            
             ImageViewer img = new ImageViewer(urlIm);
         
            cnt1.add(BorderLayout.WEST, img); }
        else{    
             EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                     createToStorage(enc, "Img" + u.getId(),"http://127.0.0.1:8000/dist/img/default-avatar.png");
            ImageViewer img = new ImageViewer(urlIm);
            
            cnt1.add(BorderLayout.WEST, img);
                

        }
        cnt1.add(BorderLayout.CENTER, cnt2);
        f.add(cnt1);
           return cnt1;
          
    }
    
    
    public Form getF() {
        return f;
    }

    public void setF(Form f) {
        this.f = f;
    }
     
}
