/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Medical.Gui;

import com.codename1.components.SpanLabel;
import com.codename1.ui.Container;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.geom.Dimension;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import tn.esprit.happyOlds.Medical.controller.MedicalController;
import tn.esprit.happyOlds.Gui.menu;
import tn.esprit.happyOlds.Medical.controller.MedicalController;
import tn.esprit.happyOlds.Medical.entity.Question;
import tn.esprit.happyOlds.MyApplication;
import tn.esprit.happyOlds.controller.UserController;

/**
 *
 * @author Yousra Trabelsi
 */
public class Medical {
     Form f,F1;
     private Form form;
    private MedicalController controller;
    private Resources theme;

    public Medical() {
        
       
       form =new Form("Forum medical");
        this.theme = MyApplication.getTheme(); 
        this.controller = new MedicalController();
        
        form.getToolbar().addCommandToOverflowMenu("Ajouter question",null,(err)->{
            
        });
        
        form.getToolbar().addCommandToOverflowMenu("Liste des réponses",null,(err)->{
            
        });
        form.getToolbar().addCommandToOverflowMenu("Ajouter une réponse",null,(err)->{
            
        });
    

      List<Question> lstQuestion=new ArrayList<>();
        
        
         //menu 
        menu m=new menu();
         m.addmenu(form);
         MedicalController sc = new MedicalController();
        lstQuestion= sc.getQuestion();
        for(int i=0;i<lstQuestion.size();i++){
            try {
                form.add(addItem(lstQuestion.get(i)));
                
            } catch (IOException ex) {
              ex.getMessage();
            }
        }
          
    }
 public Container addItem(Question q) throws IOException {
        
        Container cnt1 = new Container(new BorderLayout());
        Label lblusername = new Label(q.getUser().getUsername());
        lblusername.setSize(new Dimension(20, 20));
        Label lbDET = new Label(q.getTitre());
        Label lbDE = new Label(q.getDescription().replace("<p>","").replace("</p>","").replace("&#39;", "'"));
      
        lblusername.setSize(new Dimension(20, 20));
        Container cnt2 = new Container(BoxLayout.y());
        cnt2.add(lblusername);
        cnt2.add(lbDET);
        cnt2.add(lbDE);
        MyApplication my= new MyApplication();
        Label lblimg = new Label("icon");
       /* if(s.getUser().getPath()==null){
            EncodedImage enc = EncodedImage.
                    createFromImage(theme.getImage("round.png"), false);
            /*URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + s.getId(),"http://127.0.0.1:8000/uploads/documents/"+s.getUser().getPath());*/
          /*  ImageViewer img = new ImageViewer(enc);
            F1.add(img);
        }
        else{    
            EncodedImage enc = EncodedImage.
                    createFromImage(theme.getImage("round.png"), false);
            /*URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + s.getId(),"http://127.0.0.1:8000/uploads/documents/avatarH.jpg");*/
          /*  ImageViewer img = new ImageViewer(enc);
            F1.add(img);
                

        }*/
        cnt1.add(BorderLayout.WEST, lblimg);
        cnt1.add(BorderLayout.CENTER, cnt2);
        lbDE.addPointerPressedListener((e)->{
            F1 = new Form(q.getTitre(),BoxLayout.y());
            for(int i=0;i<q.getReponse().size();i++){
                 SpanLabel cUsername = new SpanLabel(q.getReponse().get(i).getUser().getUsername());
                
                 SpanLabel ctexte = new SpanLabel(q.getReponse().get(i).getText());
                 F1.add(cUsername);
                 F1.add(ctexte);
               /* System.out.println(q.getReponse().get(i).getText());*/
            }
       /* F1 = new Form(q.getType().toString(),BoxLayout.y());
            /*EncodedImage enc = EncodedImage.
                    createFromImage(theme.getImage("round.png"), false);
            URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + c.getId(), c.getUrlImage());
            ImageViewer img = new ImageViewer(urlIm);
            F1.add(img);*/
            /*Question question= new Question();
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
             Label lblcom = new Label("Commentaires :");
             F1.add(lblcom);
             for(int i=0;i<s.getCommenatires().size();i++){
                /* EncodedImage enc = EncodedImage.
                    createFromImage(theme.getImage("round.png"), false);
            URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + s.getId(),"http://127.0.0.1:8000/uploads/documents/avatarH.jpg");
            ImageViewer img = new ImageViewer(urlIm);*/
               /* SpanLabel cUsername = new SpanLabel(s.getCommenatires().get(i).getUser().getUsername());
                
                 SpanLabel ctexte = new SpanLabel(s.getCommenatires().get(i).getTexte());
                 F1.add(cUsername);
                 F1.add(ctexte);
             }*/
             
            F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
                form.show();
          
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

    public Form getForm() {
        return form;
    }

    public void setForm(Form form) {
        this.form = form;
    }
    
    

    
}