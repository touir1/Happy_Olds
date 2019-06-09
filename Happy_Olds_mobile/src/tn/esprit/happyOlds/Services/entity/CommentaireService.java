/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Services.entity;

import tn.esprit.happyOlds.entity.User;

/**
 *
 * @author SadfiAmine
 */
public class CommentaireService {
     private int id;
     private String Texte;
     private User User;
     private int Service;

    public CommentaireService() {
    }

    public CommentaireService(int id, String Texte, User User, int Service) {
        this.id = id;
        this.Texte = Texte;
        this.User = User;
        this.Service = Service;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTexte() {
        return Texte;
    }

    public void setTexte(String Texte) {
        this.Texte = Texte;
    }

    public User getUser() {
        return User;
    }

    public void setUser(User User) {
        this.User = User;
    }

    public int getService() {
        return Service;
    }

    public void setService(int Service) {
        this.Service = Service;
    }

    @Override
    public String toString() {
        return "CommentaireService{" + "id=" + id + ", Texte=" + Texte + ", User=" + User + ", Service=" + Service + '}';
    }
     
}
