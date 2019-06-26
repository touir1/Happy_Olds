/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Medical.Gui;

import com.codename1.components.ImageViewer;
import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.URLImage;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
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
      Form form,Form1;

    public Medical(Form Form1) {
        this.Form1 = Form1;
    }
    private MedicalController controller;
    private Resources theme;

    public Medical() {
        
       
       form =new Form("Forum medical");
        this.theme = MyApplication.getTheme(); 
        this.controller = new MedicalController();
        
        form.getToolbar().addCommandToOverflowMenu("Ajouter question",null,(err)->{
       
         TextField titre;
         TextField text;
         ComboBox<String> sujet;
   
          Button Valider;
          
            Form1 = new Form("Ajouter question ");
         //menu 
        Container cnt2 = new Container(BoxLayout.y());
         titre  = new TextField("", "titre", 10, TextArea.ANY);
        text  = new TextField("", "Description", 20, TextArea.ANY);
     
         sujet = new ComboBox<String>();
          sujet.addItem("type de question");
         sujet.addItem("ventre");
         sujet.addItem("autre");
        
         Valider = new Button("Valider");
          cnt2.add(sujet);
         cnt2.add(titre);
         cnt2.add(text);
         cnt2.add(Valider);
         Valider.addActionListener(e->{
            if(!sujet.getSelectedItem().equals(sujet.getSelectedItem().equals("Type de question"))&&(!titre.getText().isEmpty())&&(!text.getText().isEmpty())){
                MedicalController Mc=new MedicalController();
                String response=Mc.addQuestion(UserController.userConnectee.getId(),text.getText(),titre.getText(),sujet.getSelectedItem());
                System.out.println(response);
                    if(!response.isEmpty()){
                        Dialog.show("Message", "Question ajoutée", "OK", null);
                       Question q=new Question();
                        form.show();
                    }
             }
            else{
                       Dialog.show("Message", "Verifier les champs ", "OK", null);  
                    }
        });
         Form1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
              Question q=new Question();
             
                form.show();
          
            });
         Form1.add(cnt2);
         Form1.show();
         
     
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
        lbDET.setSize(new Dimension(20, 20));
        SpanLabel lbDE = new SpanLabel(q.getDescription().replace("<p>","").replace("</p>","").replace("&#39;", "'").replace("&nbsp;"," ").replace("&eacute;","é").replace("&agrave;", "à"));
       lbDE.setSize(new Dimension(40, 40));
        
        Container cnt2 = new Container(BoxLayout.y());
        cnt2.add(lblusername);
        cnt2.add(lbDET);
        cnt2.add(lbDE);
        MyApplication my= new MyApplication();
         Label lblimg = new Label();
    Image red = Image.createImage(50, 50);  
        if(q.getUser().getPath()!=null){
           

            EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + q.getId(), "http://127.0.0.1:8000/uploads/documents/"+q.getUser().getPath()); 
            //Image red = Image.createImage("file:///C:/wamp64/www/Happy_Olds/Happy_Olds_Web/web/uploads/documents/"+s.getUser().getPath());  
            
             ImageViewer img = new ImageViewer(urlIm);
         
            cnt1.add(BorderLayout.WEST, img); }
        else{    
             EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                     createToStorage(enc, "Img" + q.getId(),"http://127.0.0.1:8000/dist/img/default-avatar.png");
            ImageViewer img = new ImageViewer(urlIm);
            
            cnt1.add(BorderLayout.WEST, img);
                

        }
        cnt1.add(BorderLayout.CENTER, cnt2);
        lbDET.addPointerPressedListener((e)->{
            F1 = new Form(q.getTitre(),BoxLayout.y());
            Container cnt3 = new Container(new BorderLayout());
            Container cnt4 = new Container(BoxLayout.y());
            
            for(int i=0;i<q.getReponse().size();i++){
                 SpanLabel cUsername = new SpanLabel(q.getReponse().get(i).getUser().getUsername());
                
                 SpanLabel ctexte = new SpanLabel(q.getReponse().get(i).getText().replace("<p>","").replace("</p>","").replace("&#39;", "'").replace("&nbsp;"," ").replace("&eacute;","é").replace("&eacute;","é").replace("&agrave;", "à"));
                 cnt4.add(cUsername);
                 cnt4.add(ctexte);
               /* System.out.println(q.getReponse().get(i).getText());*/
            }
      Image red1 = Image.createImage(50, 50);  
        if(q.getUser().getPath()!=null){
           

            EncodedImage enc = EncodedImage.
                    createFromImage(red1, false);
             URLImage urlIm = URLImage.
                    createToStorage(enc, "Img" + q.getId(), "http://127.0.0.1:8000/uploads/documents/"+q.getUser().getPath()); 
            //Image red = Image.createImage("file:///C:/wamp64/www/Happy_Olds/Happy_Olds_Web/web/uploads/documents/"+s.getUser().getPath());  
            
             ImageViewer img = new ImageViewer(urlIm);
         
            cnt3.add(BorderLayout.WEST, img); }
        else{    
             EncodedImage enc = EncodedImage.
                    createFromImage(red, false);
             URLImage urlIm = URLImage.
                     createToStorage(enc, "Img" + q.getId(),"http://127.0.0.1:8000/dist/img/default-avatar.png");
            ImageViewer img = new ImageViewer(urlIm);
            
            cnt3.add(BorderLayout.WEST, img);
                

        }
        
        cnt3.add(BorderLayout.CENTER, cnt4);
             
            F1.getToolbar().addCommandToLeftBar("Back", null, (ev) -> {
                form.show();
          
            });
             
           F1.add(cnt3);
             
             F1.show();
             
           form.getToolbar().addCommandToOverflowMenu("Ajouter reponse",null,(err)->{
            
        }); 
            

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
    
      public Form getForm1() {
        return 
               Form1;
    }

    public void setForm1(Form form1) {
        this.Form1 = form1;
    }
    
    

    
}