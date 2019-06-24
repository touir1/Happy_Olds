/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Medical.entity;

import java.util.Date;
import tn.esprit.happyOlds.entity.User;

/**
 *
 * @author Yousra Trabelsi
 */
public class Reponse {
    
    private int id ;
    private User user;
    private int question;
    private String text;
    private Date dateR;
    
    
     public Reponse() {
    }

    public Reponse(int id, User user, int question, String text, Date dateR) {
        this.id = id;
        this.user = user;
        this.question = question;
        this.text = text;
        this.dateR = dateR;
    }

    @Override
    public String toString() {
        return "Reponse{" + "id=" + id + ", user=" + user + ", question=" + question + ", text=" + text + ", dateR=" + dateR + '}';
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public int getQuestion() {
        return question;
    }

    public void setQuestion(int question) {
        this.question = question;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public Date getDateR() {
        return dateR;
    }

    public void setDateR(Date dateR) {
        this.dateR = dateR;
    }
     
    
}
