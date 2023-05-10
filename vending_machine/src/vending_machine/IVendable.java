package vending_machine;

/**
 *
 * @author cecro
 */
public interface IVendable<E> {
   
   public boolean matches(E e);
   
   public IVendable clone() throws CloneNotSupportedException;
   
   public String getName();
   
   public double getPrice();
    
}
