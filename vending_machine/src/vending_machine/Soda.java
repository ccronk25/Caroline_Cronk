package vending_machine;

/**
 *
 * @author ccronk
 */
public class Soda implements Cloneable, IVendable<Soda>{
    
//--------------PROPERTIES-------------- 
    private String name = "";
    public String getName(){ return name; }
    public void setName(String newName) { name = newName; }
    
    private double price;
    public double getPrice(){ return price; }
    public void setPrice(double newPrice) { price = newPrice; }
     
//--------------CONSTRUCTORS--------------    
    //Default Constructor
    public Soda(){}
    
    //Full constructor
    public Soda(String newName, double newPrice){
        name = newName;
        price = newPrice;
    }    
    
//--------------METHODS--------------   
    /**
     * Custom matches method for quick comparisons between Candy instances.
     * @param candy the Candy to compare to
     * @return boolean, true if the candies have the same name and price
     */
    public boolean matches(Soda soda){
        if(this.getName().equals(soda.getName()) && this.getPrice() == soda.getPrice()){
            return true;
        }
        else{
            return false;
        }
    }
    
    //Clone
    @Override
    public Soda clone() throws CloneNotSupportedException{
        return (Soda) super.clone();
    }
}
