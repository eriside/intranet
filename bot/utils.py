def color_from_interaction(interaction_id: int) -> int:
 
    hex_str = hex(interaction_id)[-6:]
    hex_str = hex_str.zfill(6)  
    return int(hex_str, 16)