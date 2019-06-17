/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.happyOlds.entity;

import java.util.Date;

/**
 *
 * @author SadfiAmine
 */
public class User {
    private int id;
    private String username;
    private String role;
    private String nom;
    private String prenom;
    private Date date_naissance;
    private int scorefinal;
    private String job;
    private String ville;
    public String path;
    private String file;
    private String fullName;

    public String getFullName() {
        return fullName;
    }

    public void setFullName(String fullName) {
        this.fullName = fullName;
    }

    public User() {
    }

    public User(int id, String username, String role, String nom, String prenom, Date date_naissance, int scorefinal, String job, String ville, String path, String file) {
        this.id = id;
        this.username = username;
        this.role = role;
        this.nom = nom;
        this.prenom = prenom;
        this.date_naissance = date_naissance;
        this.scorefinal = scorefinal;
        this.job = job;
        this.ville = ville;
        this.path = path;
        this.file = file;
    }

    

    
    
    
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public Date getDate_naissance() {
        return date_naissance;
    }

    public void setDate_naissance(Date date_naissance) {
        this.date_naissance = date_naissance;
    }

    public int getScorefinal() {
        return scorefinal;
    }

    public void setScorefinal(int scorefinal) {
        this.scorefinal = scorefinal;
    }

    public String getJob() {
        return job;
    }

    public void setJob(String job) {
        this.job = job;
    }

    public String getVille() {
        return ville;
    }

    public void setVille(String ville) {
        this.ville = ville;
    }

    public String getPath() {
        return path;
    }

    public void setPath(String path) {
        this.path = path;
    }

    public String getFile() {
        return file;
    }

    public void setFile(String file) {
        this.file = file;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    @Override
    public String toString() {
        return "User{" + "id=" + id + ", username=" + username + ", role=" + role + ", nom=" + nom + ", prenom=" + prenom + ", date_naissance=" + date_naissance + ", scorefinal=" + scorefinal + ", job=" + job + ", ville=" + ville + ", path=" + path + ", file=" + file + '}';
    }
    
    
    
    
    
}
