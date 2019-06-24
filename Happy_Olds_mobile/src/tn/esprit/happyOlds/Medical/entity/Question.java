/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Medical.entity;

import tn.esprit.happyOlds.entity.User;
import java.util.Date;
import java.util.List;
/**
 *
 * @author Yousra Trabelsi
 */
public class Question {
    private int id;
    private String titre;
    private String description;
    private User user;
    private int sujet;
    private Date dateQ;
    private List<Reponse> Reponse;

    public Question() {
    }

    public Question(int id, String titre, String description, User user, int sujet, Date dateQ, List<Reponse> Reponse) {
        this.id = id;
        this.titre = titre;
        this.description = description;
        this.user = user;
        this.sujet = sujet;
        this.dateQ = dateQ;
        this.Reponse = Reponse;
    }

    @Override
    public String toString() {
        return "Question{" + "id=" + id + ", titre=" + titre + ", description=" + description + ", user=" + user + ", sujet=" + sujet + ", dateQ=" + dateQ + ", Reponse=" + Reponse + '}';
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public int getSujet() {
        return sujet;
    }

    public void setSujet(int sujet) {
        this.sujet = sujet;
    }

    public Date getDateQ() {
        return dateQ;
    }

    public void setDateQ(Date dateQ) {
        this.dateQ = dateQ;
    }

    public List<Reponse> getReponse() {
        return Reponse;
    }

    public void setReponse(List<Reponse> Reponse) {
        this.Reponse = Reponse;
    }

    
    
    
    
}
