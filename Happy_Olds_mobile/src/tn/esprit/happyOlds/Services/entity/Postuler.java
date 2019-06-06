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
public class Postuler {
    private int id ;
    private Service service;
    private User User;

    public Postuler(int id, Service service, User User) {
        this.id = id;
        this.service = service;
        this.User = User;
    }

    public Postuler() {
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public Service getService() {
        return service;
    }

    public void setService(Service service) {
        this.service = service;
    }

    public User getUser() {
        return User;
    }

    public void setUser(User User) {
        this.User = User;
    }
    
    
    
    
}
