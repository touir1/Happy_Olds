/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.Services.entity;

import java.util.Date;
import java.util.List;
import tn.esprit.happyOlds.entity.User;

/**
 *
 * @author SadfiAmine
 */
public class Service {
    private int id ;
    private String description;
    private String Valider;
    private Date Date;
    private String Type;
    private User User;
    private User UserAssocie;
    private List<Postuler> Postuler;
    private List<CommentaireService> Commenatires;

    public Service(int id, String description, String Valider, Date Date, String Type, User User, User UserAssocie, List<Postuler> Postuler, List<CommentaireService> Commenatires) {
        this.id = id;
        this.description = description;
        this.Valider = Valider;
        this.Date = Date;
        this.Type = Type;
        this.User = User;
        this.UserAssocie = UserAssocie;
        this.Postuler = Postuler;
        this.Commenatires = Commenatires;
    }

    public Service() {
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getValider() {
        return Valider;
    }

    public void setValider(String Valider) {
        this.Valider = Valider;
    }

    public Date getDate() {
        return Date;
    }

    public void setDate(Date Date) {
        this.Date = Date;
    }

    public String getType() {
        return Type;
    }

    public void setType(String Type) {
        this.Type = Type;
    }

    public User getUser() {
        return User;
    }

    public void setUser(User User) {
        this.User = User;
    }

    public User getUserAssocie() {
        return UserAssocie;
    }

    public void setUserAssocie(User UserAssocie) {
        this.UserAssocie = UserAssocie;
    }

    public List<Postuler> getPostuler() {
        return Postuler;
    }

    public void setPostuler(List<Postuler> Postuler) {
        this.Postuler = Postuler;
    }

    public List<CommentaireService> getCommenatires() {
        return Commenatires;
    }

    public void setCommenatires(List<CommentaireService> Commenatires) {
        this.Commenatires = Commenatires;
    }
    
    
    
    
}
